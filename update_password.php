<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$user = App\Models\User::where('email', 'Kylejoshua878@gmail.com')->first();
if ($user) {
    $user->password = Illuminate\Support\Facades\Hash::make('Ellah878#');
    $user->save();
    echo 'Password updated.';
} else {
    echo 'User not found.';
}
