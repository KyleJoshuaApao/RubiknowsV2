<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo_url', 'type', 'success_story_url'];

    public function getLogoPathAttribute(): ?string
    {
        return $this->logo_url;
    }
}
