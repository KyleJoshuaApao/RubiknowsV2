<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string', // Consider JSON later if needed
            'is_archived' => 'boolean'
        ]);

        $data['is_archived'] = $request->has('is_archived');
        
        Job::create($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posting created successfully.');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'is_archived' => 'boolean'
        ]);

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
