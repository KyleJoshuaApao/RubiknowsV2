<?php

namespace App\Models;

use App\Support\PublicContentCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class QuotationRequest extends Model
{
    use HasFactory;

    /**
     * Attachments are private and served only through the authenticated
     * admin download route.
     */
    public const UPLOAD_DISK = 'documents';

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
        'service_needed',
        'project_location',
        'budget',
        'timeline',
        'description',
        'attachment_path',
        'assigned_engineer_id',
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

    public function assignedEngineer()
    {
        return $this->belongsTo(User::class, 'assigned_engineer_id');
    }

    /**
     * The disk holding the attachment, or null if there is none. Older
     * attachments may still sit on the local private or default disks.
     */
    public function attachmentDisk(): ?string
    {
        if (! $this->attachment_path) {
            return null;
        }

        foreach (array_unique([self::UPLOAD_DISK, 'local', config('filesystems.default')]) as $disk) {
            if (Storage::disk($disk)->exists($this->attachment_path)) {
                return $disk;
            }
        }

        return null;
    }
}
