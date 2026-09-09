<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Append security headers to ALL web responses
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        $middleware->alias([
            'superadmin' => \App\Http\Middleware\CheckSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            $configDump = print_r(config()->all(), true);
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage(), 'config' => $configDump], 500);
            }
            return response(
                "<h1>Serverless Application Error</h1><pre>" . htmlspecialchars((string) $e) . "</pre><h2>Config Dump</h2><pre>" . htmlspecialchars($configDump) . "</pre>",
                500
            );
        });
    })->create();

$storagePath = $_ENV['APP_STORAGE'] ?? '/tmp/storage';
$app->useStoragePath($storagePath);

// Force critical configs right after application creation
$app->booting(function ($app) {
    $app['config']->set('app.maintenance.driver', 'file');
    $app['config']->set('session.driver', 'cookie');
    $app['config']->set('cache.default', 'array');
});

return $app;
