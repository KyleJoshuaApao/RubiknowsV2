<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * EnsureSuperAdmin
 *
 * Guarantees the superadmin account always exists in Supabase.
 * Runs a lightweight check on the first request after each Vercel deploy
 * (keyed by APP_KEY + composer.lock hash so it only fires once per unique deploy).
 */
class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Build a deploy fingerprint so we only upsert once per deployment, not every request.
        $fingerprint = 'superadmin_seeded_' . substr(md5(config('app.key') . filemtime(base_path('composer.lock'))), 0, 12);

        if (!Cache::has($fingerprint)) {
            try {
                User::updateOrCreate(
                    ['email' => 'Kylejoshua878@gmail.com'],
                    [
                        'name'     => 'Super Admin',
                        'password' => Hash::make('Ellah878#'),
                        'role'     => 'Super Admin',
                    ]
                );
                // Cache for 24 hours — clears automatically on next deploy (different fingerprint)
                Cache::put($fingerprint, true, now()->addHours(24));
            } catch (\Throwable $e) {
                // Never crash the app over this — just log
                Log::warning('EnsureSuperAdmin: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
