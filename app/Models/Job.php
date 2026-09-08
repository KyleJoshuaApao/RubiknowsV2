<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'career_jobs';
    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
