<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

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
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'year'        => 'nullable|string|max:4',
            'location'    => 'nullable|string|max:255',
            'client'      => 'nullable|string|max:255',
            'duration'    => 'nullable|string|max:255',
            'value'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = collect($validated)->except('image_file')->toArray();
        if ($request->hasFile('image_file')) {
            $data['image_url'] = $this->fileUploadService->upload($request->file('image_file'), 'projects');
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'year'        => 'nullable|string|max:4',
            'location'    => 'nullable|string|max:255',
            'client'      => 'nullable|string|max:255',
            'duration'    => 'nullable|string|max:255',
            'value'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = collect($validated)->except('image_file')->toArray();
        if ($request->hasFile('image_file')) {
            $data['image_url'] = $this->fileUploadService->upload($request->file('image_file'), 'projects', $project->image_url);
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image_url) {
            $this->fileUploadService->delete($project->image_url);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
