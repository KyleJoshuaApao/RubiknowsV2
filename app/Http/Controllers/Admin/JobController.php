<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Http\Requests\Admin\JobRequest;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::withCount('applications')->latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(JobRequest $request)
    {
        $data = $request->validated();

        $data['is_archived'] = $request->has('is_archived');

        Job::create($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posting created successfully.');
    }

    public function show(Job $job)
    {
        return view('admin.jobs.show', compact('job'));
    }
    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(JobRequest $request, Job $job)
    {
        $data = $request->validated();

        $data['is_archived'] = $request->has('is_archived');

        $job->update($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posting updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting deleted.');
    }
}
