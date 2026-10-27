<?php

namespace App\Support;

use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

final class MediaUrl
{
    /**
     * Resolve a stored media reference to a URL the browser can load.
     *
     * - Full URLs are returned as they are (old localhost URLs are made relative).
     * - Paths starting with "/" point at files shipped in public/.
     * - Anything else is a path on the media disk.
     */
    public static function for(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $parts = parse_url($path);
            $host = strtolower((string) ($parts['host'] ?? ''));
            $urlPath = (string) ($parts['path'] ?? '');

            // Records created while APP_URL pointed at localhost stay usable
            // from whichever host serves the site today.
            if (in_array($host, ['localhost', '127.0.0.1', '::1'], true) && str_starts_with($urlPath, '/storage/')) {
                return $urlPath;
            }

            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        $disk = FileUploadService::PUBLIC_UPLOAD_DISK;

        // A same-origin path avoids a stale APP_URL leaking into pages.
        if (config("filesystems.disks.{$disk}.driver") === 'local') {
            return '/storage/'.ltrim($path, '/');
        }

        return Storage::disk($disk)->url($path);
    }
}
