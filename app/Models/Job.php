<?php

namespace App\Models;

use App\Models\Concerns\RefreshesPublicContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, RefreshesPublicContent;

    protected $table = 'career_jobs';
    protected $fillable = [
        'title',
        'type',
        'location',
        'description',
        'requirements',
        'is_archived'
    ];
    protected $casts = [
        'requirements' => 'json',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
