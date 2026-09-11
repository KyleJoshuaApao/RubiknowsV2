<?php

// Vercel serverless overrides — must run before Laravel boots
// Use /tmp for storage on Vercel since the filesystem is read-only except for /tmp
$isVercel = getenv('VERCEL') === '1';
$storagePath = $isVercel ? '/tmp/storage' : 'storage';

putenv("APP_STORAGE=$storagePath");
$_ENV['APP_STORAGE'] = $storagePath;
putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';

// Only try to create directories if not on Vercel (where /tmp is already writable)
// or if we're using a local storage path
if (!$isVercel) {
    $directories = [
        "$storagePath/logs",
        "$storagePath/framework/views",
        "$storagePath/framework/cache/data",
        "$storagePath/framework/sessions",
        "$storagePath/bootstrap/cache",
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
} else {
    // On Vercel, ensure the bootstrap/cache directory exists in /tmp
    $bootstrapCacheDir = $storagePath . '/bootstrap/cache';
    if (!is_dir($bootstrapCacheDir)) {
        mkdir($bootstrapCacheDir, 0777, true);
    }
}

// Set Laravel cache and session paths
$_ENV['APP_SERVICES_CACHE'] = "$storagePath/bootstrap/cache/services.php";
$_ENV['APP_PACKAGES_CACHE'] = "$storagePath/bootstrap/cache/packages.php";
$_ENV['APP_CONFIG_CACHE'] = "$storagePath/bootstrap/cache/config.php";
$_ENV['APP_ROUTES_CACHE'] = "$storagePath/bootstrap/cache/routes.php";
$_ENV['APP_EVENTS_CACHE'] = "$storagePath/bootstrap/cache/events.php";

$_ENV['APP_MAINTENANCE_DRIVER'] = 'file';
$_SERVER['APP_MAINTENANCE_DRIVER'] = 'file';
putenv('APP_MAINTENANCE_DRIVER=file');

$_ENV['SESSION_DRIVER'] = 'cookie';
$_SERVER['SESSION_DRIVER'] = 'cookie';
putenv('SESSION_DRIVER=cookie');

$_ENV['CACHE_STORE'] = 'array';
$_SERVER['CACHE_STORE'] = 'array';
putenv('CACHE_STORE=array');

require __DIR__ . '/../public/index.php';