<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\StoreQuotationRequest;
use App\Jobs\SendNewJobApplicationNotification;
use App\Mail\NewContactMessageNotification;
use App\Mail\NewQuotationRequestNotification;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\GalleryMedia;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\NewsPost;
use App\Models\Project;
use App\Models\QuotationRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\PublicContentCache;
use App\Support\SubmissionFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    private const MAP_COLUMNS = ['id', 'slug', 'title', 'category_id', 'location', 'latitude', 'longitude'];

    public function index()
    {
        $home = Cache::remember(PublicContentCache::key(PublicContentCache::HOME), now()->addMinutes(5), function (): array {
            $settings = Setting::whereIn('key', ['home_stats_bar', 'home_careers'])->pluck('value', 'key');

            $stats = json_decode((string) $settings->get('home_stats_bar', '[]'), true);
            $careers = json_decode((string) $settings->get('home_careers', '{}'), true);

            return [
                'services' => $this->orderedServices()->take(6)->get(),
                'featuredProjects' => Project::query()
                    ->orderByRaw("case when status = 'Featured' then 0 else 1 end")
                    ->latest()
                    ->take(3)
                    ->get(),
                'mapProjects' => Project::mapPins(self::MAP_COLUMNS),
                'testimonial' => $this->publishedTestimonials()->first(),
                'openJobs' => Job::where('is_archived', false)->latest()->take(3)->get(['id', 'title', 'type', 'location']),
                'news' => NewsPost::visible()->take(3)->get(),
                'homeStats' => array_values(array_filter(is_array($stats) ? $stats : [], fn ($stat) => is_array($stat) && filled($stat['value'] ?? null) && filled($stat['label'] ?? null))),
                'homeCareers' => is_array($careers) ? array_filter($careers, 'filled') : [],
            ];
        });

        return view('public.home', $home);
    }

    public function about()
    {
        return view('public.about', [
            // Wrapped in an array because the cache never stores a bare null.
            'testimonial' => PublicContentCache::page('about', fn () => [$this->publishedTestimonials()->first()])[0],
        ]);
    }

    public function services()
    {
        return view('public.services', [
            'services' => PublicContentCache::page('services', fn () => $this->orderedServices()->get()),
        ]);
    }

    public function serviceDetails(Service $service)
    {
        return view('public.service-details', [
            'service' => $service,
            'otherServices' => $this->orderedServices()->whereKeyNot($service->getKey())->get(['id', 'title']),
        ]);
    }

    public function projects(Request $request)
    {
        $categories = PublicContentCache::page('project-categories', fn () => Project::query()
            ->whereNotNull('category_id')
            ->where('category_id', '!=', '')
            ->distinct()
            ->orderBy('category_id')
            ->pluck('category_id'));

        $category = $categories->contains($request->query('category')) ? $request->query('category') : null;

        $projects = $this->cachedPaginate(
            'projects:'.md5((string) $category),
            Project::query()->when($category, fn ($query) => $query->where('category_id', $category))->latest(),
            12,
        )->appends(array_filter(['category' => $category]));

        $mapProjects = Cache::remember(
            PublicContentCache::key(PublicContentCache::PROJECT_MAP),
            now()->addMinutes(5),
            fn () => Project::mapPins(self::MAP_COLUMNS)
        );

        return view('public.projects', compact('projects', 'mapProjects', 'categories', 'category'));
    }

    public function projectDetails(Project $project)
    {
        return view('public.project-details', [
            'project' => $project,
            'moreProjects' => Project::query()->whereKeyNot($project->getKey())->latest()->take(3)->get(),
        ]);
    }

    public function gallery()
    {
        $media = $this->cachedPaginate('gallery', GalleryMedia::latest(), 24);

        return view('public.gallery', compact('media'));
    }

    public function testimonials()
    {
        $testimonials = $this->cachedPaginate('testimonials', $this->publishedTestimonials(), 12);

        return view('public.testimonials', compact('testimonials'));
    }

    public function clients()
    {
        $clients = $this->cachedPaginate('clients', Client::where('type', 'Client')->latest(), 20);
        [$partners, $sponsors] = PublicContentCache::page('client-partners', fn () => [
            Client::where('type', 'Partner')->latest()->get(),
            Client::where('type', 'Sponsor')->latest()->get(),
        ]);

        return view('public.clients', compact('clients', 'partners', 'sponsors'));
    }

    public function careers()
    {
        $jobs = $this->cachedPaginate('careers', Job::where('is_archived', false)->latest(), 10);

        return view('public.careers', compact('jobs'));
    }

    public function contact()
    {
        return view('public.contact', [
            'serviceOptions' => PublicContentCache::page('service-options', fn () => $this->orderedServices()->pluck('title')),
        ]);
    }

    public function submitContact(StoreContactMessageRequest $request)
    {
        $message = $this->storeWithAttachments($request, 'messages', fn (array $attachments) => ContactMessage::create([
            ...Arr::except($request->validated(), 'attachments'),
            'attachments' => $attachments ?: null,
        ]));

        if (! $message) {
            return $this->submissionFailed($request, 'form', 'We could not send your message. Please try again shortly.');
        }

        $this->notifyAdmin(fn (string $admin) => Mail::to($admin)->queue(new NewContactMessageNotification($message)));

        return back()->with('success', 'Thank you for reaching out. We have received your message and will reply shortly.');
    }

    public function submitQuotation(StoreQuotationRequest $request)
    {
        $quotation = $this->storeWithAttachments($request, 'quotations', fn (array $attachments) => QuotationRequest::create([
            ...Arr::except($request->validated(), 'attachments'),
            'attachments' => $attachments ?: null,
            'status' => 'Pending',
        ]));

        if (! $quotation) {
            return $this->submissionFailed($request, 'quotation', 'We could not submit your request. Please try again shortly.');
        }

        $this->notifyAdmin(fn (string $admin) => Mail::to($admin)->queue(new NewQuotationRequestNotification($quotation)));

        return back()->with('success', 'Your quotation request has been submitted successfully. Our engineering team will review it and contact you soon.');
    }

    /**
     * Store the optional files, then the record. On any failure nothing is kept.
     */
    private function storeWithAttachments($request, string $directory, callable $create)
    {
        $attachments = [];

        try {
            $attachments = SubmissionFiles::store($request->file('attachments', []), $directory);

            return $create($attachments);
        } catch (\Throwable $e) {
            SubmissionFiles::delete($attachments);

            try {
                report($e);
            } catch (\Throwable) {
                // The user-facing error is still the correct response.
            }

            return null;
        }
    }

    private function submissionFailed($request, string $field, string $message)
    {
        return back()
            ->withInput($request->except('attachments'))
            ->withErrors([$field => $message]);
    }

    public function applyForJob(StoreJobApplicationRequest $request)
    {
        $data = $request->validated();

        $disk = JobApplication::UPLOAD_DISK;
        $resumePath = null;
        $portfolioPath = null;

        try {
            $resumePath = $request->file('resume')->store('applications/resumes', $disk);
            if (! $resumePath) {
                throw new \RuntimeException('The resume could not be stored.');
            }

            if ($request->hasFile('portfolio')) {
                $portfolioPath = $request->file('portfolio')->store('applications/portfolios', $disk);
                if (! $portfolioPath) {
                    throw new \RuntimeException('The portfolio could not be stored.');
                }
            }

            $application = DB::transaction(fn () => JobApplication::create([
                'job_id' => $request->jobId(),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'cover_letter' => $data['message'] ?? null,
                'resume_path' => $resumePath,
                'portfolio_path' => $portfolioPath,
                'status' => 'Received',
            ]));
        } catch (\Throwable $e) {
            Storage::disk($disk)->delete(array_filter([$resumePath, $portfolioPath]));

            // A misconfigured production logger must not turn this handled
            // submission failure back into an HTTP 500 response.
            try {
                report($e);
            } catch (\Throwable) {
                // The user-facing error below is still the correct response.
            }

            return back()
                ->withInput($request->except(['resume', 'portfolio']))
                ->withErrors(['application' => 'We could not submit your application. Please try again shortly.']);
        }

        $this->notifyAdmin(fn (string $admin) => SendNewJobApplicationNotification::dispatch($application->id, $admin));

        return back()->with('success', 'Your application has been submitted successfully. We will be in touch soon!');
    }

    private function publishedTestimonials()
    {
        return Testimonial::where('is_published', true)->latest();
    }

    private function orderedServices()
    {
        return Service::query()->orderByDesc('is_featured')->oldest('id');
    }

    /**
     * Paginate through the public page cache. Only the rows and total are
     * cached; the paginator is rebuilt for each request so its links match it.
     */
    private function cachedPaginate(string $name, Builder $query, int $perPage): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage();

        [$items, $total] = PublicContentCache::page("{$name}:page-{$page}", fn (): array => [
            (clone $query)->forPage($page, $perPage)->get(),
            $query->toBase()->getCountForPagination(),
        ]);

        return new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }

    /**
     * Send an admin notification without letting a mail failure break the submission.
     */
    private function notifyAdmin(callable $send): void
    {
        try {
            $send(Setting::getAdminEmail());
        } catch (\Throwable $e) {
            Log::error('Mail Error: '.$e->getMessage());
        }
    }
}
