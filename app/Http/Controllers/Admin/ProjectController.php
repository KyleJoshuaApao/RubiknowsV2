<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Services\FileUploadService;
use App\Support\PublicContentCache;

class ProjectController extends Controller
{
    private const MAP_COLUMNS = ['id', 'title', 'latitude', 'longitude'];

    public function __construct(private FileUploadService $fileUploadService)
    {
    }

    public function index()
    {
        $projects = Project::latest()->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create', ['mapProjects' => Project::mapPins(self::MAP_COLUMNS)]);
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
        return view('admin.projects.edit', [
            'project' => $project,
            'mapProjects' => Project::mapPins(self::MAP_COLUMNS, except: $project),
        ]);
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
        $this->fileUploadService->delete($project->image_url);
        $project->delete();
        PublicContentCache::forgetProjects();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
