<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('This is a test email from RubiKnows SMTP.', function ($message) {
        $message->to('kylejoshua878@gmail.com')
                ->subject('Test SMTP Connection');
    });
    echo "Email sent successfully.\n";
} catch (\Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
}
