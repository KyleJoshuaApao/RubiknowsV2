<?php

// Vercel serverless overrides — must run before Laravel boots
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('QUEUE_CONNECTION=sync');
putenv('FILESYSTEM_DISK=local');
putenv('APP_MAINTENANCE_DRIVER=array');

if (! is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

require __DIR__ . '/../public/index.php';
