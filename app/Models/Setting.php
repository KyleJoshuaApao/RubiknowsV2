<?php

namespace App\Models;

use App\Support\PublicContentCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'description', 'group'];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Decode a JSON setting, falling back when it is missing or malformed.
     */
    public static function getJson(string $key, array $default = []): array
    {
        $decoded = json_decode((string) static::getValue($key, ''), true);

        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * All settings as a key => value map, cached for public pages.
     *
     * @return array<string, mixed>
     */
    public static function allCached(): array
    {
        return Cache::remember(
            PublicContentCache::SITE_SETTINGS,
            now()->addHour(),
            fn () => static::pluck('value', 'key')->toArray()
        );
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
