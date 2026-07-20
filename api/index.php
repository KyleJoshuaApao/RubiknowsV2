<?php

// Vercel serverless overrides — must run before Laravel boots
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('QUEUE_CONNECTION=sync');
putenv('FILESYSTEM_DISK=local');
putenv('APP_MAINTENANCE_DRIVER=array');
putenv('APP_DEBUG=true');

$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['QUEUE_CONNECTION'] = 'sync';
$_ENV['FILESYSTEM_DISK'] = 'local';
$_ENV['APP_MAINTENANCE_DRIVER'] = 'array';
$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';

if (! is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

require __DIR__ . '/../public/index.php';
