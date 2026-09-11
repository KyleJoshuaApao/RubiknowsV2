<?php

use App\Http\Middleware\CheckSuperAdmin;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Append security headers to ALL web responses
        $middleware->append(SecurityHeaders::class);

        $middleware->alias([
            'superadmin' => CheckSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Allow Laravel to handle exceptions normally
        // The previous closure caught ALL throwables including ValidationException
    })->create();

$storagePath = $_ENV['APP_STORAGE'] ?? $_SERVER['APP_STORAGE'] ?? null;
if ($storagePath) {
    $app->useStoragePath($storagePath);
}

// Vercel's serverless filesystem needs runtime-safe stores; local and tests use config/env.
$app->booting(function ($app) {
    if ($_ENV['APP_STORAGE'] ?? $_SERVER['APP_STORAGE'] ?? false) {
        $app['config']->set('app.maintenance.driver', 'file');
        $app['config']->set('session.driver', 'cookie');
        $app['config']->set('cache.default', 'array');
    }
});

return $app;
