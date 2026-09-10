<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryMedia extends Model
{
    use HasFactory;

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
