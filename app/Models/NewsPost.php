<?php

namespace App\Models;

use App\Models\Concerns\RefreshesPublicContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use RefreshesPublicContent;

    protected $fillable = [
        'title',
        'body',
        'image_path',
        'posted_at',
        'facebook_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Published posts, newest first. Posts scheduled for later stay hidden.
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->where('posted_at', '<=', now())->latest('posted_at');
    }
}
