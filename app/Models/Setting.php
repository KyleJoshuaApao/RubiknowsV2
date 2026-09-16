<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    // Explicit fillable to prevent mass assignment attacks
    protected $fillable = ['key', 'value', 'description', 'group'];

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
    public static function getAdminEmail(): string
    {
        $email = trim((string) static::getValue('contact_email', ''));

        return filter_var($email, FILTER_VALIDATE_EMAIL)
            ? $email
            : (string) config('mail.from.address');
    }
}
