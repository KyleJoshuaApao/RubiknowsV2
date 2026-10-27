<?php

namespace App\Models;

use App\Support\PublicContentCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => PublicContentCache::forgetAdminNotificationCounts());
        static::deleted(fn () => PublicContentCache::forgetAdminNotificationCounts());
    }

    /**
     * Resumes and portfolios are private; see the "documents" disk.
     */
    public const UPLOAD_DISK = 'documents';

    protected $fillable = [
        'job_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'resume_path',
        'portfolio_path',
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

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
