<?php

// Vercel serverless overrides — must run before Laravel boots
// Use /tmp for storage on Vercel since the filesystem is read-only except for /tmp
$storagePath = '/tmp/storage';

// DEBUGGING: Catch all errors and print them to the screen so we can see what's actually failing
ini_set('display_errors', 1);
error_reporting(E_ALL);

set_exception_handler(function ($e) {
    http_response_code(500);
    echo "<h1>Fatal Exception!</h1>";
    echo "<pre>" . print_r($e, true) . "</pre>";
    exit(1);
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo "<h1>Fatal PHP Error!</h1>";
        echo "<pre>" . print_r($error, true) . "</pre>";
    }
});

putenv("APP_STORAGE=$storagePath");
$_ENV['APP_STORAGE'] = $storagePath;
putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';

// Ensure all necessary directories exist in /tmp
$directories = [
    "$storagePath/logs",
    "$storagePath/framework/views",
    "$storagePath/framework/cache/data",
    "$storagePath/framework/sessions",
    "$storagePath/bootstrap/cache",
    "/tmp/views",
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
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