<?php

// Minimal diagnostic - outputs info before Laravel boots
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

echo "PHP Version: " . PHP_VERSION . "\n";
echo "Extensions: " . implode(', ', get_loaded_extensions()) . "\n";

// Try booting Laravel with error catching
echo "\n--- Attempting Laravel boot ---\n";
try {
    putenv('VIEW_COMPILED_PATH=/tmp/views');
    putenv('CACHE_STORE=array');
    putenv('SESSION_DRIVER=cookie');
    putenv('LOG_CHANNEL=stderr');
    putenv('QUEUE_CONNECTION=sync');
    putenv('FILESYSTEM_DISK=local');
    putenv('APP_MAINTENANCE_DRIVER=array');

    $_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
    $_ENV['CACHE_STORE'] = 'array';
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_ENV['QUEUE_CONNECTION'] = 'sync';
    $_ENV['FILESYSTEM_DISK'] = 'local';
    $_ENV['APP_MAINTENANCE_DRIVER'] = 'array';

    if (! is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0777, true);
    }

    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->handleRequest(\Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
    echo "\n!!! EXCEPTION !!!\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
