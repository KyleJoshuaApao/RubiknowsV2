<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    use HasFactory;

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
}
