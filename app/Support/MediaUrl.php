<?php

namespace App\Support;

final class MediaUrl
{
    /**
     * Resolve uploaded public-storage paths as same-origin URLs and retain approved
     * remote media URLs. Relative local URLs avoid stale APP_URL values leaking
     * localhost hosts into production pages and being blocked by CSP.
     */
    public static function for(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (!filter_var($path, FILTER_VALIDATE_URL)) {
            return '/storage/' . ltrim($path, '/');
        }

        $parts = parse_url($path);
        $host = strtolower((string) ($parts['host'] ?? ''));
        $urlPath = (string) ($parts['path'] ?? '');

        // Old records created when APP_URL was localhost should remain usable
        // from whichever host is serving the application today.
        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true) && str_starts_with($urlPath, '/storage/')) {
            return $urlPath;
        }

        return $path;
    }
}
