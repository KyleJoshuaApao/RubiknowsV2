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
use App\Models\Project;
use App\Models\QuotationRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\PublicContentCache;
use Illuminate\Http\Request;
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
        $home = Cache::remember(PublicContentCache::HOME, now()->addMinutes(5), function (): array {
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
                'homeStats' => array_values(array_filter(is_array($stats) ? $stats : [], fn ($stat) => is_array($stat) && filled($stat['value'] ?? null) && filled($stat['label'] ?? null))),
                'homeCareers' => is_array($careers) ? array_filter($careers, 'filled') : [],
            ];
        });

        return view('public.home', $home);
    }

    public function about()
    {
        return view('public.about', [
            'testimonial' => $this->publishedTestimonials()->first(),
        ]);
    }

    public function services()
    {
        return view('public.services', [
            'services' => $this->orderedServices()->get(),
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
        $categories = Project::query()
            ->whereNotNull('category_id')
            ->where('category_id', '!=', '')
            ->distinct()
            ->orderBy('category_id')
            ->pluck('category_id');

        $category = $categories->contains($request->query('category')) ? $request->query('category') : null;

        $projects = Project::query()
            ->when($category, fn ($query) => $query->where('category_id', $category))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $mapProjects = Cache::remember(
            PublicContentCache::PROJECT_MAP,
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
        $media = GalleryMedia::latest()->paginate(24);

        return view('public.gallery', compact('media'));
    }

    public function testimonials()
    {
        $testimonials = $this->publishedTestimonials()->paginate(12);

        return view('public.testimonials', compact('testimonials'));
    }

    public function clients()
    {
        $clients = Client::where('type', 'Client')->latest()->paginate(20);
        $partners = Client::where('type', 'Partner')->latest()->get();
        $sponsors = Client::where('type', 'Sponsor')->latest()->get();

        return view('public.clients', compact('clients', 'partners', 'sponsors'));
    }

    public function careers()
    {
        $jobs = Job::where('is_archived', false)->latest()->paginate(10);

        return view('public.careers', compact('jobs'));
    }

    public function contact()
    {
        return view('public.contact', [
            'serviceOptions' => $this->orderedServices()->pluck('title'),
        ]);
    }

    public function submitContact(StoreContactMessageRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        $this->notifyAdmin(fn (string $admin) => Mail::to($admin)->queue(new NewContactMessageNotification($message)));

        return back()->with('success', 'Thank you for reaching out. We have received your message and will reply shortly.');
    }

    public function submitQuotation(StoreQuotationRequest $request)
    {
        $disk = QuotationRequest::UPLOAD_DISK;
        $attachmentPath = null;

        try {
            // Stored privately; served only via the authenticated admin route.
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('quotations', $disk);
                if (! $attachmentPath) {
                    throw new \RuntimeException('The attachment could not be stored.');
                }
            }

            $quotation = QuotationRequest::create([
                ...Arr::except($request->validated(), 'attachment'),
                'attachment_path' => $attachmentPath,
                'status' => 'Pending',
            ]);
        } catch (\Throwable $e) {
            if ($attachmentPath) {
                Storage::disk($disk)->delete($attachmentPath);
            }

            try {
                report($e);
            } catch (\Throwable) {
                // The user-facing error below is still the correct response.
            }

            return back()
                ->withInput($request->except('attachment'))
                ->withErrors(['quotation' => 'We could not submit your request. Please try again shortly.']);
        }

        $this->notifyAdmin(fn (string $admin) => Mail::to($admin)->queue(new NewQuotationRequestNotification($quotation)));

        return back()->with('success', 'Your quotation request has been submitted successfully. Our engineering team will review it and contact you soon.');
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
