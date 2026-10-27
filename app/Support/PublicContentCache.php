<?php

namespace App\Support;

use App\Models\Client;
use App\Models\GalleryMedia;
use App\Models\Job;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

final class PublicContentCache
{
    public const HOME = 'public-content:home:v2';
    public const PROJECT_MAP = 'public-content:project-map:v1';
    public const FOOTER_SERVICES = 'public-content:footer-services:v1';
    public const SECTIONS = 'public-content:sections:v1';
    public const SITE_SETTINGS = 'site_settings';
    public const ADMIN_NOTIFICATION_COUNTS = 'admin:notification-counts:v1';

    /**
     * Which optional public sections have content, so navigation never links
     * to an empty page.
     *
     * @return array{projects: bool, gallery: bool, testimonials: bool, clients: bool, open_jobs: int}
     */
    public static function sections(): array
    {
        return Cache::remember(self::SECTIONS, now()->addMinutes(10), fn (): array => [
            'projects' => Project::query()->exists(),
            'gallery' => GalleryMedia::query()->exists(),
            'testimonials' => Testimonial::query()->where('is_published', true)->exists(),
            'clients' => Client::query()->exists(),
            'open_jobs' => Job::query()->where('is_archived', false)->count(),
        ]);
    }

    public static function footerServices()
    {
        return Cache::remember(self::FOOTER_SERVICES, now()->addMinutes(10), fn () => Service::query()
            ->orderByDesc('is_featured')
            ->oldest('id')
            ->take(6)
            ->get(['id', 'slug', 'title']));
    }

    /**
     * Clear everything derived from CMS content shown on public pages.
     */
    public static function forgetPublicContent(): void
    {
        foreach ([self::HOME, self::PROJECT_MAP, self::FOOTER_SERVICES, self::SECTIONS] as $key) {
            Cache::forget($key);
        }
    }

    public static function forgetHome(): void
    {
        self::forgetPublicContent();
    }

    public static function forgetProjects(): void
    {
        self::forgetPublicContent();
    }

    public static function forgetSettings(): void
    {
        Cache::forget(self::SITE_SETTINGS);
        self::forgetPublicContent();
    }

    public static function forgetAdminNotificationCounts(): void
    {
        Cache::forget(self::ADMIN_NOTIFICATION_COUNTS);
    }
}
