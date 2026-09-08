<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;
use App\Mail\NewContactMessageNotification;

try {
    $application = ContactMessage::latest()->first();
    if (!$application) {
        echo "No contact message found in database.\n";
        exit;
    }
    
    echo "Sending contact ID: " . $application->id . "\n";
    \Illuminate\Support\Facades\Config::set('queue.default', 'sync');
    // Send it synchronously by ignoring the queue
    Mail::to('kylejoshua878@gmail.com')->send(new NewContactMessageNotification($application));
    
    echo "Mailable sent successfully.\n";
} catch (\Exception $e) {
    echo "Error sending mailable: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
