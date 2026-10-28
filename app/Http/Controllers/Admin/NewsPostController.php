<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsPostRequest;
use App\Models\NewsPost;
use App\Services\FileUploadService;

class NewsPostController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService)
    {
    }

    public function index()
    {
        $posts = NewsPost::latest('posted_at')->paginate(15);

        return view('admin.news.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.news.form', ['post' => new NewsPost(['posted_at' => now(), 'is_published' => true])]);
    }

    public function store(NewsPostRequest $request)
    {
        $data = $this->data($request);

        if ($request->hasFile('image')) {
            try {
                $data['image_path'] = $this->fileUploadService->upload($request->file('image'), 'news');
            } catch (\Throwable $exception) {
                return $this->uploadFailure('image', $exception);
            }
        }

        NewsPost::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News post published.');
    }

    public function edit(NewsPost $news)
    {
        return view('admin.news.form', ['post' => $news]);
    }

    public function update(NewsPostRequest $request, NewsPost $news)
    {
        $data = $this->data($request);

        if ($request->hasFile('image')) {
            try {
                $data['image_path'] = $this->fileUploadService->upload($request->file('image'), 'news', $news->image_path);
            } catch (\Throwable $exception) {
                return $this->uploadFailure('image', $exception);
            }
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News post updated.');
    }

    public function destroy(NewsPost $news)
    {
        $this->fileUploadService->delete($news->image_path);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News post deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function data(NewsPostRequest $request): array
    {
        return [
            ...$request->safe()->only(['title', 'body', 'posted_at', 'facebook_url']),
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
