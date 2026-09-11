<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryMediaRequest;
use App\Models\GalleryMedia;
use App\Services\FileUploadService;

class GalleryMediaController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $media = GalleryMedia::latest()->paginate(12);

        return view('admin.gallery.index', compact('media'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(GalleryMediaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('media_file')) {
            $data['url'] = $this->fileUploadService->upload($request->file('media_file'), 'gallery');
            $data['thumbnail_url'] = $data['url'];
        }

        unset($data['media_file']);

        GalleryMedia::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Media uploaded successfully.');
    }

    public function update(GalleryMediaRequest $request, GalleryMedia $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('media_file')) {
            $data['url'] = $this->fileUploadService->upload($request->file('media_file'), 'gallery', $gallery->url);
            $data['thumbnail_url'] = $data['url'];
        }

        unset($data['media_file']);

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Media updated successfully.');
    }

    public function destroy(GalleryMedia $gallery)
    {
        $this->fileUploadService->delete($gallery->url);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Media deleted successfully.');
    }
}
