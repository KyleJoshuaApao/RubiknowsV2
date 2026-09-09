<?php

$envFile = __DIR__ . '/.env';
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;

    list($key, $value) = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);

    // Remove quotes if they exist in the .env file itself
    if (preg_match('/^"(.*)"$/', $value, $matches) || preg_match("/^'(.*)'$/", $value, $matches)) {
        $value = $matches[1];
    }

    echo "Updating $key...\n";

    // Write value to a temp file
    file_put_contents('temp_env_value.txt', $value);

    // Remove old variable
    shell_exec("cmd.exe /c \"vercel env rm $key production -y\"");
    
    // Add new variable
    shell_exec("cmd.exe /c \"vercel env add $key production < temp_env_value.txt\"");
}

echo "Done fixing environment variables!\n";
unlink('temp_env_value.txt');
