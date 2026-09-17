<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Services\FileUploadService;
use App\Support\PublicContentCache;

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
        return view('admin.projects.create', ['mapProjects' => $this->mapProjects()]);
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image_file')) {
            try {
                $data['image_url'] = $this->fileUploadService->upload($request->file('image_file'), 'projects');
            } catch (\Throwable $exception) {
                return $this->uploadFailure('image_file', $exception);
            }
        }

        Project::create($data);
        PublicContentCache::forgetProjects();

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project' => $project, 'mapProjects' => $this->mapProjects($project)]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        if ($request->hasFile('image_file')) {
            try {
                $data['image_url'] = $this->fileUploadService->upload($request->file('image_file'), 'projects', $project->image_url);
            } catch (\Throwable $exception) {
                return $this->uploadFailure('image_file', $exception);
            }
        }

        $project->update($data);
        PublicContentCache::forgetProjects();

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image_url) {
            $this->fileUploadService->delete($project->image_url);
        }
        $project->delete();
        PublicContentCache::forgetProjects();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    private function mapProjects(?Project $except = null)
    {
        return Project::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($except, fn ($query) => $query->whereKeyNot($except->getKey()))
            ->get(['id', 'title', 'latitude', 'longitude']);
    }
}
