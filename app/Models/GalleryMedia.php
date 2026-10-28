<?php

namespace App\Models;

use App\Models\Concerns\HasPreviewContent;
use App\Models\Concerns\RefreshesPublicContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryMedia extends Model
{
    use HasFactory, HasPreviewContent, RefreshesPublicContent;

    protected $fillable = [
        'type',
        'title',
        'url',
        'thumbnail_url',
        'album_name',
        'category',
        'before_after_pair_id'
    ];
}
