<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesSubmissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobApplicationReplyRequest;
use App\Http\Requests\Admin\JobApplicationRequest;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    use HandlesSubmissions;

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
        $application->update(['status' => $request->validated('status')]);

        return back()->with('success', 'Application status updated.');
    }

    public function destroy(JobApplication $application)
    {
        $documents = array_filter([$application->resume_path, $application->portfolio_path]);
        if ($documents !== []) {
            Storage::disk(JobApplication::UPLOAD_DISK)->delete($documents);
        }

        $application->delete();

        return redirect()->route('admin.applications.index')->with('success', 'Application deleted.');
    }

    public function reply(JobApplicationReplyRequest $request, JobApplication $application)
    {
        return $this->sendReply($application, $request->validated(), 'Update regarding your application at RUBIKNOWS');
    }

    public function downloadResume(JobApplication $application)
    {
        return $this->downloadDocument($application->resume_path);
    }

    public function downloadPortfolio(JobApplication $application)
    {
        return $this->downloadDocument($application->portfolio_path);
    }

    private function downloadDocument(?string $path)
    {
        abort_unless($path, 404);

        $disk = Storage::disk(JobApplication::UPLOAD_DISK);
        abort_unless($disk->exists($path), 404);

        return $disk->download($path);
    }
}
