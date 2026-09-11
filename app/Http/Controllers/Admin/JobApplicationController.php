<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobApplicationReplyRequest;
use App\Http\Requests\Admin\JobApplicationRequest;
use App\Mail\AdminReplyNotification;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('job')->latest()->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    public function update(JobApplicationRequest $request, JobApplication $application)
    {
        $data = $request->validated();

        $application->update(['status' => $data['status']]);

        return back()->with('success', 'Application status updated.');
    }

    public function destroy(JobApplication $application)
    {
        if ($application->resume_path) {
            Storage::disk(config('filesystems.default'))->delete($application->resume_path);
        }
        if ($application->portfolio_path) {
            Storage::disk(config('filesystems.default'))->delete($application->portfolio_path);
        }

        $application->delete();

        return redirect()->route('admin.applications.index')->with('success', 'Application deleted.');
    }

    public function reply(JobApplicationReplyRequest $request, JobApplication $application)
    {
        $data = $request->validated();

        $updateData = [
            'reply_message' => $data['reply_message'],
            'replied_at' => now(),
        ];

        // Only update status if provided in request
        if ($data['status'] !== null) {
            $updateData['status'] = $data['status'];
        }

        $application->update($updateData);

        try {
            $subject = 'Update regarding your application at RubiKnows';
            $senderName = $data['sender_name'] ?? 'The RubiKnows Team';
            Mail::to($application->email)->send(new AdminReplyNotification($application->name, $data['reply_message'], $subject, $senderName));
        } catch (\Exception $e) {
            Log::error('Mail Error (Reply): '.$e->getMessage());

            return back()->with('error', 'Reply saved, but email could not be sent.');
        }

        return back()->with('success', 'Reply sent successfully.');
    }
}
