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
            $settings = Setting::whereIn('key', [
                'home_stats_bar', 'home_markets', 'home_marquee', 'home_careers',
            ])->pluck('value', 'key');

            $homeCareers = json_decode($settings->get('home_careers', '{}'), true);

            return [
                'featuredProjects' => Project::where('status', 'Featured')->latest()->take(3)->get(),
                'mapProjects' => Project::mapPins(self::MAP_COLUMNS),
                'services' => Service::latest()->take(6)->get(),
                'testimonials' => $this->publishedTestimonials()->take(3)->get(),
                'homeStats' => json_decode($settings->get('home_stats_bar', '[]'), true),
                'homeMarkets' => json_decode($settings->get('home_markets', '[]'), true),
                'homeMarquee' => json_decode($settings->get('home_marquee', '[]'), true),
                'homeCareers' => array_merge([
                    'title' => 'Build your career with the industry leaders.',
                    'description' => 'We are actively recruiting talented people to deliver work that lasts.',
                ], is_array($homeCareers) ? $homeCareers : []),
            ];
        });

        return view('public.home', $home);
    }

    public function about()
    {
        return view('public.about');
    }

    public function services()
    {
        $services = Service::latest()->get();
        $testimonials = $this->publishedTestimonials()->take(3)->get();

        return view('public.services', compact('services', 'testimonials'));
    }

    public function serviceDetails(Service $service)
    {
        return view('public.service-details', compact('service'));
    }

    public function projects()
    {
        $projects = Project::latest()->paginate(12);
        $mapProjects = Cache::remember(
            PublicContentCache::PROJECT_MAP,
            now()->addMinutes(5),
            fn () => Project::mapPins(self::MAP_COLUMNS)
        );

        return view('public.projects', compact('projects', 'mapProjects'));
    }

    public function projectDetails(Project $project)
    {
        return view('public.project-details', compact('project'));
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
        return view('public.contact');
    }

    public function submitContact(StoreContactMessageRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        $this->notifyAdmin(fn (string $admin) => Mail::to($admin)->queue(new NewContactMessageNotification($message)));

        return back()->with('success', 'Thank you for reaching out. We have received your message and will reply shortly.');
    }

    public function submitQuotation(StoreQuotationRequest $request)
    {
        // Stored privately; served only via the authenticated admin route.
        $attachmentPath = $request->hasFile('attachment')
            ? $request->file('attachment')->store('quotations', QuotationRequest::UPLOAD_DISK)
            : null;

        $quotation = QuotationRequest::create([
            ...Arr::except($request->validated(), 'attachment'),
            'attachment_path' => $attachmentPath,
            'status' => 'Pending',
        ]);

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
