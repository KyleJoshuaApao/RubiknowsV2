<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
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

        $viteHosts = app()->environment('local')
            ? 'http://127.0.0.1:* http://localhost:* ws://127.0.0.1:* ws://localhost:*'
            : '';

        // Inline scripts must carry the nonce; injected <script> tags and on*= attributes
        // are blocked. Alpine.js still needs 'unsafe-eval' to evaluate x-* expressions.
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' 'unsafe-eval' cdn.jsdelivr.net $viteHosts",
            "style-src 'self' fonts.bunny.net cdn.jsdelivr.net 'unsafe-inline' $viteHosts",
            "font-src 'self' fonts.bunny.net data:",
            "img-src 'self' data: blob: https://images.unsplash.com https://placehold.co https://*.tile.openstreetmap.org",
            "connect-src 'self' $viteHosts",
            "media-src 'self' blob: *",
            "frame-src 'self'",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "object-src 'none'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
