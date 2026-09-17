<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

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
