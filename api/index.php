<?php

// Enable error reporting so we can actually see what's wrong
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Vercel serverless overrides — must run before Laravel boots
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('QUEUE_CONNECTION=sync');
putenv('FILESYSTEM_DISK=local');
putenv('APP_MAINTENANCE_DRIVER=array');

// Also set via $_ENV and $_SERVER for Laravel's env() helper
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['QUEUE_CONNECTION'] = 'sync';
$_ENV['FILESYSTEM_DISK'] = 'local';
$_ENV['APP_MAINTENANCE_DRIVER'] = 'array';

$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/views';
$_SERVER['CACHE_STORE'] = 'array';
$_SERVER['SESSION_DRIVER'] = 'cookie';
$_SERVER['LOG_CHANNEL'] = 'stderr';
$_SERVER['QUEUE_CONNECTION'] = 'sync';
$_SERVER['FILESYSTEM_DISK'] = 'local';
$_SERVER['APP_MAINTENANCE_DRIVER'] = 'array';

if (! is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

require __DIR__ . '/../public/index.php';
