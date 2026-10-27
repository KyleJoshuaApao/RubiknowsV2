<?php

namespace App\Models;

use App\Models\Concerns\RefreshesPublicContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, RefreshesPublicContent;

    protected $fillable = [
        'client_name',
        'company',
        'role',
        'avatar_url',
        'quote',
        'is_published'
    ];

    public function getAvatarPathAttribute(): ?string
    {
        return $this->avatar_url;
    }
}
