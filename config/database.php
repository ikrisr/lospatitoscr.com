<?php

$envFile = __DIR__ . '/../.env';
$env = [];

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        $env[$name] = $value;
    }
}

return [
    'host' => $env['DB_HOST'] ?? '127.0.0.1',
    'dbname' => $env['DB_NAME'] ?? 'mydatabase',
    'username' => $env['DB_USER'] ?? 'root',
    'password' => $env['DB_PASS'] ?? 'toor',
    'charset' => $env['DB_CHARSET'] ?? 'utf8mb4'
];
