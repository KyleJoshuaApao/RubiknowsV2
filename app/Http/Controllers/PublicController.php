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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContactMessageNotification;
use App\Mail\NewQuotationRequestNotification;
use App\Mail\NewJobApplicationNotification;

class PublicController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::where('status', 'Featured')->latest()->take(3)->get();
        $services = Service::latest()->take(6)->get();
        $testimonials = Testimonial::where('is_published', true)->latest()->get();
        $clients = Client::latest()->get();
        $media = GalleryMedia::latest()->take(6)->get();

        return view('public.home', compact('featuredProjects', 'services', 'testimonials', 'clients', 'media'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function services()
    {
        $services = Service::latest()->get();
        return view('public.services', compact('services'));
    }

    public function projects()
    {
        $projects = Project::latest()->paginate(12);
        return view('public.projects', compact('projects'));
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
        $jobs = Job::where('is_archived', false)->latest()->get();
        return view('public.careers', compact('jobs'));
    }

    public function applyForJob(Request $request, Job $job)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'cover_letter' => 'nullable|string|max:5000',
            'resume'       => 'required|file|mimes:pdf,doc,docx|max:5120',
            'portfolio'    => 'nullable|file|mimes:pdf,zip|max:10240',
        ]);

        // Store on the default configured disk
        $resumePath    = $request->file('resume')->store('applications/resumes');
        $portfolioPath = $request->hasFile('portfolio') ? $request->file('portfolio')->store('applications/portfolios') : null;

        $application = JobApplication::create([
            'job_id' => $job->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'cover_letter' => $data['cover_letter'],
            'resume_path' => $resumePath,
            'portfolio_path' => $portfolioPath,
            'status' => 'Received',
        ]);

        try {
            Mail::to(Setting::getAdminEmail())->send(new NewJobApplicationNotification($application));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return back()->with('success', 'Your application has been submitted successfully. We will be in touch soon!');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_published', true)->latest()->get();
        return view('public.testimonials', compact('testimonials'));
    }

    public function clients()
    {
        $clients  = Client::whereIn('type', ['Client', 'client'])->orWhereNull('type')->latest()->get();
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
            Mail::to(Setting::getAdminEmail())->send(new NewContactMessageNotification($message));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for reaching out. We have received your message and will reply shortly.');
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
            Mail::to(Setting::getAdminEmail())->send(new NewQuotationRequestNotification($quotation));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return back()->with('success', 'Your quotation request has been submitted successfully. Our engineering team will review it and contact you soon.');
    }
}
