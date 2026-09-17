<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

final class PublicContentCache
{
    public const HOME = 'public-content:home:v1';
    public const PROJECT_MAP = 'public-content:project-map:v1';
    public const ADMIN_NOTIFICATION_COUNTS = 'admin:notification-counts:v1';

    public static function forgetHome(): void
    {
        Cache::forget(self::HOME);
    }

    public static function forgetProjects(): void
    {
        Cache::forget(self::HOME);
        Cache::forget(self::PROJECT_MAP);
    }

    public static function forgetAdminNotificationCounts(): void
    {
        Cache::forget(self::ADMIN_NOTIFICATION_COUNTS);
    }
}
