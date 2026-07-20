<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    /**
     * Boot model events to automate slug generation.
     */
    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = \Illuminate\Support\Str::slug($service->title) . '-' . uniqid();
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title')) {
                $service->slug = \Illuminate\Support\Str::slug($service->title) . '-' . $service->id;
            }
        });
    }
}
