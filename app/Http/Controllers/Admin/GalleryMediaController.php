<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryMedia;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Photo,Video',
            'category' => 'required|string|max:100',
            'album_name' => 'nullable|string|max:100',
            'media_file' => 'required|file|mimes:jpeg,png,jpg,webp,mp4,mov|max:20480',
        ]);

        $data = $request->except('media_file');

        if ($request->hasFile('media_file')) {
            $data['url'] = $this->fileUploadService->upload($request->file('media_file'), 'gallery');
            $data['thumbnail_url'] = $data['url']; // Simplify for now
        }

        GalleryMedia::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Media uploaded successfully.');
    }

    public function edit(GalleryMedia $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryMedia $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Photo,Video',
            'category' => 'required|string|max:100',
            'album_name' => 'nullable|string|max:100',
            'media_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov|max:20480',
        ]);

        $data = $request->except('media_file');

        if ($request->hasFile('media_file')) {
            $data['url'] = $this->fileUploadService->upload($request->file('media_file'), 'gallery', $gallery->url);
            $data['thumbnail_url'] = $data['url'];
        }

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
