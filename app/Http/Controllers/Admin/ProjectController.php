<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'location' => 'nullable|string|max:255',
            'client' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
        ]);

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'location' => 'nullable|string|max:255',
            'client' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
        ]);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
