<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryMedia;
use App\Models\NewsPost;
use App\Models\Project;
use App\Support\PublicContentCache;

/**
 * Turns preview rows (visible only to signed-in admins) into public content.
 */
class PreviewContentController extends Controller
{
    private const TYPES = [
        'projects' => Project::class,
        'gallery' => GalleryMedia::class,
        'news' => NewsPost::class,
    ];

    public function publish(string $type, int $id)
    {
        $model = self::TYPES[$type] ?? abort(404);
        $model::query()->where('is_preview', true)->findOrFail($id)->forceFill(['is_preview' => false])->save();
        PublicContentCache::forgetPublicContent();

        return back()->with('success', 'Now visible to the public.');
    }

    public function publishAll(string $type)
    {
        $model = self::TYPES[$type] ?? abort(404);
        $count = $model::query()->where('is_preview', true)->update(['is_preview' => false]);
        PublicContentCache::forgetPublicContent();

        return back()->with('success', trans_choice(':count item is|:count items are', $count, ['count' => $count]).' now visible to the public.');
    }
}
