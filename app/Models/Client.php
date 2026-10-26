<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public const TYPES = ['Client', 'Partner', 'Sponsor'];

    protected $fillable = ['name', 'logo_url', 'type', 'success_story_url'];

    public function getLogoPathAttribute(): ?string
    {
        return $this->logo_url;
    }
}
