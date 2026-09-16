<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * Application documents are private and must not depend on the default
     * upload disk, which may be configured for public CMS media.
     */
    public const UPLOAD_DISK = 'local';

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
