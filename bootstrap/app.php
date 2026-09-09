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
        // Allow Laravel to handle exceptions normally
        // The previous closure caught ALL throwables including ValidationException
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
