<?php
$host = 'db.ozqvwdakfcprxageihyz.supabase.co';
$port = 5432;
$connection = @fsockopen($host, $port, $errno, $errstr, 5);
if (is_resource($connection)) {
    echo "Connection to $host on port $port is successful!\n";
    fclose($connection);
} else {
    echo "Connection to $host failed: $errstr ($errno)\n";
}
