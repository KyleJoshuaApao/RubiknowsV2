<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->headers->remove('X-Powered-By');
        $isLocal = app()->environment('local');
        $viteHosts = $isLocal ? "http://127.0.0.1:* http://localhost:* ws://127.0.0.1:* ws://localhost:* [::1]:*" : "";
        $unsafeEval = $isLocal ? "'unsafe-eval'" : "";

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' cdn.jsdelivr.net 'unsafe-inline' $unsafeEval $viteHosts",
            "style-src 'self' fonts.bunny.net 'unsafe-inline' $viteHosts",
            "font-src 'self' fonts.bunny.net data:",
            "img-src 'self' data: blob: *",
            "connect-src 'self' $viteHosts",
            "media-src 'self' blob: *",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);
        return $response;
    }
}