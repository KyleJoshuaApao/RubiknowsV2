<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Laravel can
    | register multiple view paths and will check them in the given order.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. Additionally, you may make the value null to disable
    | the view compiler entirely.
    |
    */

    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views')) ?: storage_path('framework/views')),
];


