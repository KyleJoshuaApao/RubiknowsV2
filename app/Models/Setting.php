<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Get the contact email or fallback to system mail config.
     */
    public static function getAdminEmail()
    {
        return static::getValue('contact_email', config('mail.from.address'));
    }
}
