<?php

// Vercel serverless overrides — must run before Laravel boots
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('QUEUE_CONNECTION=sync');
putenv('FILESYSTEM_DISK=s3');
putenv('APP_MAINTENANCE_DRIVER=array');
putenv('DB_HOST=aws-0-ap-northeast-1.pooler.supabase.com');
putenv('DB_USERNAME=postgres.fvdxejbpmmmblaijtwkz');
putenv('DB_HOST=aws-0-ap-northeast-1.pooler.supabase.com');
putenv('DB_USERNAME=postgres.fvdxejbpmmmblaijtwkz');
putenv('APP_DEBUG=true');

$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['QUEUE_CONNECTION'] = 'sync';
$_ENV['FILESYSTEM_DISK'] = 's3';
$_ENV['APP_MAINTENANCE_DRIVER'] = 'array';
$_ENV['DB_HOST'] = 'aws-0-ap-northeast-1.pooler.supabase.com';
$_ENV['DB_USERNAME'] = 'postgres.fvdxejbpmmmblaijtwkz';
$_ENV['DB_HOST'] = 'aws-0-ap-northeast-1.pooler.supabase.com';
$_ENV['DB_USERNAME'] = 'postgres.fvdxejbpmmmblaijtwkz';
$_SERVER['DB_HOST'] = 'aws-0-ap-northeast-1.pooler.supabase.com';
$_SERVER['DB_USERNAME'] = 'postgres.fvdxejbpmmmblaijtwkz';
$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';

if (! is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

require __DIR__ . '/../public/index.php';
