<?php
require 'bootstrap/app.php';
$app = require 'bootstrap/app.php';
$config = $app->make('config');
echo 'View compiled: ';
var_dump($config->get('view.compiled'));
echo PHP_EOL;
echo 'Storage path: ';
var_dump($app->storagePath());
echo PHP_EOL;

