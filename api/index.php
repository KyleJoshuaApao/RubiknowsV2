<?php

putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

if (! is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

require __DIR__ . '/../public/index.php';
