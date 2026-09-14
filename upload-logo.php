<?php
/**
 * One-shot script: uploads LOGO.png to Supabase Storage via the S3-compatible API.
 * Run with: php upload-logo.php
 */

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$endpoint  = $_ENV['AWS_ENDPOINT'];   // https://xxx.supabase.co/storage/v1/s3
$bucket    = $_ENV['AWS_BUCKET'];
$key       = $_ENV['AWS_ACCESS_KEY_ID'];
$secret    = $_ENV['AWS_SECRET_ACCESS_KEY'];
$region    = $_ENV['AWS_DEFAULT_REGION'] ?? 'us-east-1';
$publicUrl = $_ENV['AWS_URL'];        // https://xxx.supabase.co/storage/v1/object/public/rubiknows

$files = [
    'logos/LOGO.png' => __DIR__ . '/public/LOGO.png',
];

$s3 = new Aws\S3\S3Client([
    'version'                 => 'latest',
    'region'                  => $region,
    'endpoint'                => $endpoint,
    'use_path_style_endpoint' => true,
    'credentials'             => ['key' => $key, 'secret' => $secret],
]);

foreach ($files as $objectKey => $localPath) {
    echo "Uploading $objectKey ... ";
    try {
        $s3->putObject([
            'Bucket'      => $bucket,
            'Key'         => $objectKey,
            'Body'        => fopen($localPath, 'r'),
            'ContentType' => 'image/png',
            'ACL'         => 'public-read',
        ]);
        echo "OK\n";
        echo "Public URL: $publicUrl/$objectKey\n";
    } catch (Exception $e) {
        echo "FAILED: " . $e->getMessage() . "\n";
    }
}
