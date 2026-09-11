<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

\App\Models\User::whereIn('email', ['example@gmail.com', 'superadmin@gmail.com'])->delete();
$user = \App\Models\User::updateOrCreate(
    ['email' => 'Kylejoshua878@gmail.com'],
    [
        'name' => 'Super Admin',
        'password' => \Illuminate\Support\Facades\Hash::make('Ellah878#'),
        'role' => 'Super Admin'
    ]
);
echo "Updated User ID: " . $user->id . "\n";
