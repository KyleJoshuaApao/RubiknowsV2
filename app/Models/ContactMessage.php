<?php

namespace App\Models;

use App\Support\PublicContentCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => PublicContentCache::forgetAdminNotificationCounts());
        static::deleted(fn () => PublicContentCache::forgetAdminNotificationCounts());
    }

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'subject',
        'message',
        'attachment_path',
        'status',
        'reply_message',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }
}
