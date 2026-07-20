<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
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
}
