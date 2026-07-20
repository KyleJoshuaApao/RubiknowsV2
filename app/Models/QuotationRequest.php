<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignedEngineer()
    {
        return $this->belongsTo(User::class, 'assigned_engineer_id');
    }
}
