<?php

use App\Http\Middleware\BlockSpamSubmissions;
use App\Http\Middleware\CheckSuperAdmin;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Render terminates TLS at its load balancer; trust it so client IPs
        // (used by rate limiting) and the https scheme are read correctly.
        $middleware->trustProxies(at: '*');

        $middleware->append(SecurityHeaders::class);

        $middleware->alias([
            'admin' => EnsureAdmin::class,
            'superadmin' => CheckSuperAdmin::class,
            'spam' => BlockSpamSubmissions::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Visitors who are not signed in get a plain "not found" for admin pages,
        // so the private sign-in address is never revealed by a redirect.
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if (! $request->expectsJson()) {
                return response()->view('errors.404', [], 404);
            }
        });
    })->create();

$storagePath = $_ENV['APP_STORAGE'] ?? $_SERVER['APP_STORAGE'] ?? null;
if ($storagePath) {
    $app->useStoragePath($storagePath);
}

// Serverless filesystems need runtime-safe stores; local and tests use config/env.
$app->booting(function ($app) {
    if ($_ENV['APP_STORAGE'] ?? $_SERVER['APP_STORAGE'] ?? false) {
        $app['config']->set('app.maintenance.driver', 'file');
        $app['config']->set('session.driver', 'cookie');
    }
});

return $app;
