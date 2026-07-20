<?php

// Minimal diagnostic - outputs info before Laravel boots
ini_set('display_errors', '1');
error_reporting(E_ALL);

echo "PHP Version: " . PHP_VERSION . "\n";
echo "Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
echo "PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n";

// Check critical paths
echo "\n--- Path checks ---\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "vendor/autoload exists: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'YES' : 'NO') . "\n";
echo "public/index.php exists: " . (file_exists(__DIR__ . '/../public/index.php') ? 'YES' : 'NO') . "\n";
echo "bootstrap/app.php exists: " . (file_exists(__DIR__ . '/../bootstrap/app.php') ? 'YES' : 'NO') . "\n";
echo ".env exists: " . (file_exists(__DIR__ . '/../.env') ? 'YES' : 'NO') . "\n";
echo "config/app.php exists: " . (file_exists(__DIR__ . '/../config/app.php') ? 'YES' : 'NO') . "\n";

// Check env vars
echo "\n--- ENV checks ---\n";
echo "APP_KEY: " . (getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? $_SERVER['APP_KEY'] ?? 'NOT SET')) . "\n";
echo "DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? $_SERVER['DB_CONNECTION'] ?? 'NOT SET')) . "\n";
echo "DB_HOST: " . (getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'NOT SET')) . "\n";

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

    echo "About to require vendor/autoload.php...\n";
    require __DIR__ . '/../vendor/autoload.php';
    echo "Autoloader loaded successfully.\n";

    echo "About to require bootstrap/app.php...\n";
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "App bootstrapped successfully.\n";

    echo "About to handle request...\n";
    $app->handleRequest(\Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
    echo "\n!!! EXCEPTION !!!\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
