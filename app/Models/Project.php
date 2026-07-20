<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

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
