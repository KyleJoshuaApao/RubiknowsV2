<?php

$publicUploadRoot = env('PUBLIC_STORAGE_PATH', storage_path('app/public'));
$privateUploadRoot = env('PRIVATE_STORAGE_PATH', storage_path('app/private'));

// Uploads go to Supabase Storage (S3 protocol) when its keys are configured, so
// they survive redeploys. Without the keys they stay on the local disk.
$supabaseUrl = rtrim((string) env('SUPABASE_URL', ''), '/');
$useSupabaseStorage = $supabaseUrl !== ''
    && filled(env('SUPABASE_S3_ACCESS_KEY_ID'))
    && filled(env('SUPABASE_S3_SECRET_ACCESS_KEY'));
$mediaBucket = env('SUPABASE_MEDIA_BUCKET', 'media');
$supabaseDisk = [
    'driver' => 's3',
    'key' => env('SUPABASE_S3_ACCESS_KEY_ID'),
    'secret' => env('SUPABASE_S3_SECRET_ACCESS_KEY'),
    'region' => env('SUPABASE_S3_REGION', 'ap-northeast-2'),
    'endpoint' => $supabaseUrl.'/storage/v1/s3',
    'use_path_style_endpoint' => true,
    'throw' => true,
    'report' => false,
];

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | "media" holds public uploads (project, service and gallery images).
    | "documents" holds private uploads (resumes, portfolios, quotation
    | attachments) that are only served through authenticated admin routes.
    |
    */

    'disks' => [

        'media' => $useSupabaseStorage
            ? [...$supabaseDisk, 'bucket' => $mediaBucket, 'url' => $supabaseUrl.'/storage/v1/object/public/'.$mediaBucket]
            : [
                'driver' => 'local',
                'root' => $publicUploadRoot,
                'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
                'visibility' => 'public',
                'throw' => true,
                'report' => false,
            ],

        'documents' => $useSupabaseStorage
            ? [...$supabaseDisk, 'bucket' => env('SUPABASE_DOCUMENTS_BUCKET', 'documents')]
            : [
                'driver' => 'local',
                'root' => $privateUploadRoot,
                'throw' => false,
                'report' => false,
            ],

        'local' => [
            'driver' => 'local',
            'root' => $privateUploadRoot,
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => $publicUploadRoot,
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => true,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => $publicUploadRoot,
    ],

];
