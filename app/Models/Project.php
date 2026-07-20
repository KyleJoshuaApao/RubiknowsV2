<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Explicit fillable to prevent mass assignment attacks
    protected $fillable = [
        'title', 'category_id', 'status', 'year', 'location',
        'client', 'duration', 'value', 'description',
        'image_url', 'cover_image_path', 'slug',
    ];

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
                $project->slug = \Illuminate\Support\Str::slug($project->title) . '-' . uniqid();
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title')) {
                $project->slug = \Illuminate\Support\Str::slug($project->title) . '-' . $project->id;
            }
        });
    }
}
