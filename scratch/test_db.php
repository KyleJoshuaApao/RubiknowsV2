<?php

$regions = [
    'aws-0-us-east-1.pooler.supabase.com',
    'aws-0-us-west-1.pooler.supabase.com',
    'aws-0-us-west-2.pooler.supabase.com',
    'aws-0-ap-southeast-1.pooler.supabase.com',
    'aws-0-ap-northeast-1.pooler.supabase.com',
    'aws-0-ap-northeast-2.pooler.supabase.com',
    'aws-0-ap-south-1.pooler.supabase.com',
    'aws-0-ap-southeast-2.pooler.supabase.com',
    'aws-0-eu-west-1.pooler.supabase.com',
    'aws-0-eu-west-2.pooler.supabase.com',
    'aws-0-eu-west-3.pooler.supabase.com',
    'aws-0-eu-central-1.pooler.supabase.com',
    'aws-0-ca-central-1.pooler.supabase.com',
    'aws-0-sa-east-1.pooler.supabase.com',
];

$user = 'postgres.dyvxkhbnptihzniwwxtn';
$pass = 'MariaAntoniaKyleJoshua878';

echo "Testing all Supabase regions for $user...\n";

foreach ($regions as $region) {
    try {
        $pdo = new PDO("pgsql:host=$region;port=5432;dbname=postgres", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 2]);
        echo "SUCCESS: Connected to $region (port 5432)!\n";
        exit(0);
    } catch (Exception $e) {}
    
    try {
        $pdo = new PDO("pgsql:host=$region;port=6543;dbname=postgres", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 2]);
        echo "SUCCESS: Connected to $region (port 6543)!\n";
        exit(0);
    } catch (Exception $e) {}
}

echo "FAILED to connect to any region.\n";
