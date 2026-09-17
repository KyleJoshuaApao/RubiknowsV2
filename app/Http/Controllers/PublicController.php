<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\GalleryMedia;
use App\Models\Job;
use App\Models\ContactMessage;
use App\Models\QuotationRequest;
use App\Models\JobApplication;
use App\Models\Setting;
use App\Support\PublicContentCache;
use App\Jobs\SendNewJobApplicationNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Mail\NewContactMessageNotification;
use App\Mail\NewQuotationRequestNotification;

class PublicController extends Controller
{
    public function index()
    {
        $home = Cache::remember(PublicContentCache::HOME, now()->addMinutes(5), function (): array {
            $settings = Setting::whereIn('key', [
                'home_stats_bar', 'home_markets', 'home_marquee', 'home_careers',
            ])->pluck('value', 'key');

            $homeCareers = json_decode($settings->get('home_careers', '{}'), true);

            return [
                'featuredProjects' => Project::where('status', 'Featured')->latest()->take(3)->get(),
                'mapProjects' => $this->mapProjects(),
                'services' => Service::latest()->take(6)->get(),
                'testimonials' => Testimonial::where('is_published', true)->latest()->take(3)->get(),
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
        $testimonials = Testimonial::where('is_published', true)->latest()->take(3)->get();
        return view('public.services', compact('services', 'testimonials'));
    }

    public function serviceDetails(Service $service)
    {
        return view('public.service-details', compact('service'));
    }

    public function projects()
    {
        $projects = Project::latest()->paginate(12);
        $mapProjects = Cache::remember(PublicContentCache::PROJECT_MAP, now()->addMinutes(5), fn () => $this->mapProjects());
        return view('public.projects', compact('projects', 'mapProjects'));
    }

    private function mapProjects()
    {
        return Project::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get(['id', 'slug', 'title', 'category_id', 'location', 'latitude', 'longitude']);
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

    public function careers()
    {
        $jobs = Job::where('is_archived', false)->latest()->paginate(10);
        return view('public.careers', compact('jobs'));
    }

    public function applyForJob(Request $request)
    {
        $data = $request->validate([
            'job_title'    => 'required|string',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'message'      => 'nullable|string|max:5000',
            'resume'       => 'required|file|mimes:pdf,doc,docx|max:5120',
            'portfolio'    => 'nullable|file|mimes:pdf,zip|max:10240',
        ]);

        $job = Job::where('title', $data['job_title'])->first();

        $disk = JobApplication::UPLOAD_DISK;
        $resumePath = null;
        $portfolioPath = null;

        try {
            $resumePath = $request->file('resume')->store('applications/resumes', $disk);
            if (!$resumePath) {
                throw new \RuntimeException('The resume could not be stored.');
            }

            if ($request->hasFile('portfolio')) {
                $portfolioPath = $request->file('portfolio')->store('applications/portfolios', $disk);
                if (!$portfolioPath) {
                    throw new \RuntimeException('The portfolio could not be stored.');
                }
            }

            $application = DB::transaction(fn () => JobApplication::create([
                'job_id' => $job ? $job->id : null,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'cover_letter' => $data['message'] ?? null,
                'resume_path' => $resumePath,
                'portfolio_path' => $portfolioPath,
                'status' => 'Received',
            ]));
        } catch (\Throwable $e) {
            foreach (array_filter([$resumePath, $portfolioPath]) as $path) {
                Storage::disk($disk)->delete($path);
            }

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

        try {
            SendNewJobApplicationNotification::dispatch($application->id, Setting::getAdminEmail());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return back()->with('success', 'Your application has been submitted successfully. We will be in touch soon!');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_published', true)->latest()->paginate(12);
        return view('public.testimonials', compact('testimonials'));
    }

    public function clients()
    {
        $clients  = Client::whereIn('type', ['Client', 'client'])->orWhereNull('type')->latest()->paginate(20);
        $partners = Client::whereIn('type', ['Partner', 'partner'])->latest()->get();
        $sponsors = Client::whereIn('type', ['Sponsor', 'sponsor'])->latest()->get();
        return view('public.clients', compact('clients', 'partners', 'sponsors'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($data);

        try {
            Mail::to(Setting::getAdminEmail())->queue(new NewContactMessageNotification($message));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thank you for reaching out. We have received your message and will reply shortly.');
    }

    public function submitQuotation(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'company'          => 'nullable|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:20',
            'service_needed'   => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'budget'           => 'nullable|string|max:100',
            'timeline'         => 'nullable|string|max:100',
            'description'      => 'required|string|max:10000',
            'attachment'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240',
        ]);

        // Store attachment privately; serve only via authenticated admin route
        $attachmentPath = $request->hasFile('attachment') ? $request->file('attachment')->store('quotations') : null;

        $quotation = QuotationRequest::create([
            'name' => $data['name'],
            'company' => $data['company'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'service_needed' => $data['service_needed'],
            'project_location' => $data['project_location'],
            'budget' => $data['budget'],
            'timeline' => $data['timeline'],
            'description' => $data['description'],
            'attachment_path' => $attachmentPath,
            'status' => 'Pending',
        ]);

        try {
            Mail::to(Setting::getAdminEmail())->queue(new NewQuotationRequestNotification($quotation));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your quotation request has been submitted successfully. Our engineering team will review it and contact you soon.');
    }
}
