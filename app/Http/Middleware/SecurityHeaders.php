<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /** The only third-party scripts, each pinned to one version: maps and the admin text editor. */
    public const LEAFLET_BASE = 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/';

    public const QUILL_BASE = 'https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/';

    public function handle(Request $request, Closure $next): Response
    {
        // Generate the per-request nonce before views render so inline <script nonce="…">
        // tags and the @vite tags can reference it.
        $nonce = Vite::useCspNonce();

        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->headers->remove('X-Powered-By');

        // Only the public website belongs in search results.
        if (! $request->routeIs('public.*', 'sitemap', 'robots')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $viteHosts = app()->environment('local')
            ? 'http://127.0.0.1:* http://localhost:* ws://127.0.0.1:* ws://localhost:*'
            : '';

        // Uploaded media is served from Supabase Storage when it is configured.
        $storageOrigin = $this->origin((string) config('filesystems.disks.media.url'));
        $leaflet = self::LEAFLET_BASE;
        $quill = self::QUILL_BASE;

        // Inline scripts must carry the nonce; injected <script> tags and on*= attributes
        // are blocked. Alpine.js still needs 'unsafe-eval' to evaluate x-* expressions.
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' 'unsafe-eval' {$leaflet} {$quill} {$viteHosts}",
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net {$leaflet} {$quill} {$viteHosts}",
            "font-src 'self' https://fonts.bunny.net data:",
            "img-src 'self' data: blob: https://images.unsplash.com https://*.tile.openstreetmap.org {$leaflet} {$storageOrigin}",
            "media-src 'self' blob: {$storageOrigin}",
            "connect-src 'self' {$viteHosts}",
            "frame-src 'self'",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "object-src 'none'",
        ]);
        $response->headers->set('Content-Security-Policy', preg_replace('/\s+(?=;|$)/', '', $csp));

        return $response;
    }

    private function origin(string $url): string
    {
        $parts = parse_url($url);

        if (! isset($parts['scheme'], $parts['host']) || ! in_array($parts['scheme'], ['http', 'https'], true)) {
            return '';
        }

        if (in_array($parts['host'], ['localhost', '127.0.0.1'], true)) {
            return '';
        }

        return $parts['scheme'].'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');
    }
}
