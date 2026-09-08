<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReplyNotification;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('job')->latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        if ($application->status === 'Received') {
            $application->update(['status' => 'Under Review']);
        }
        
        return view('admin.applications.show', compact('application'));
    }

    public function update(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:Received,Under Review,Interview Scheduled,Accepted,Rejected'
        ]);

        $application->update(['status' => $request->status]);
        return back()->with('success', 'Application status updated.');
    }

    public function destroy(JobApplication $application)
    {
        if ($application->resume_path) {
            Storage::disk('public')->delete($application->resume_path);
        }
        if ($application->portfolio_path) {
            Storage::disk('public')->delete($application->portfolio_path);
        }
        
        $application->delete();
        return redirect()->route('admin.applications.index')->with('success', 'Application deleted.');
    }

    public function reply(Request $request, JobApplication $application)
    {
        $data = $request->validate([
            'reply_message' => 'required|string|max:5000',
            'sender_name' => 'nullable|string|max:255',
        ]);

        $application->update([
            'reply_message' => $data['reply_message'],
            'replied_at' => now(),
            'status' => 'Interview Scheduled', // or keep current status
        ]);

        try {
            $subject = 'Update regarding your application at RubiKnows';
            $senderName = $data['sender_name'] ?? 'The RubiKnows Team';
            Mail::to($application->email)->send(new AdminReplyNotification($application->name, $data['reply_message'], $subject, $senderName));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error (Reply): ' . $e->getMessage());
            return back()->with('error', 'Reply saved, but email could not be sent.');
        }

        return back()->with('success', 'Reply sent successfully.');
    }
}
