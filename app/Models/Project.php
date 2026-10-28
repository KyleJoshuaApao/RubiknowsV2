<?php

namespace App\Models;

use App\Models\Concerns\HasPreviewContent;
use App\Models\Concerns\RefreshesPublicContent;
use App\Support\MindanaoMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasPreviewContent, RefreshesPublicContent;

    protected $fillable = [
        'title', 'category_id', 'status', 'year', 'location',
        'client', 'duration', 'value', 'description',
        'image_url', 'cover_image_path', 'slug', 'latitude', 'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Projects whose coordinates fall inside the Mindanao map boundary.
     *
     * @param  array<int, string>  $columns
     */
    public static function mapPins(array $columns, ?self $except = null): Collection
    {
        return static::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [MindanaoMap::MIN_LATITUDE, MindanaoMap::MAX_LATITUDE])
            ->whereBetween('longitude', [MindanaoMap::MIN_LONGITUDE, MindanaoMap::MAX_LONGITUDE])
            ->when($except, fn ($query) => $query->whereKeyNot($except->getKey()))
            ->latest()
            ->get($columns)
            ->filter(fn (self $project) => MindanaoMap::contains($project->latitude, $project->longitude))
            ->values();
    }

    /**
     * Get the cover image path (alias for image_url).
     */
    public function getCoverImagePathAttribute()
    {
        return $this->image_url;
    }

    /**
     * Get the category name (alias for category_id).
     */
    public function getCategoryAttribute()
    {
        return $this->category_id;
    }

    /**
     * Boot model events to automate slug generation.
     */
    protected static function booted()
    {
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title).'-'.uniqid();
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title')) {
                $project->slug = Str::slug($project->title).'-'.$project->id;
            }
        });
    }
}
