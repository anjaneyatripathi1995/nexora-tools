<?php
// For PHP built-in server when run from project root (e.g. php -S localhost:8000 server.php).
// Prefer: php artisan serve (serves from public/).
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$root = __DIR__ . '/public';

if ($uri !== '/' && file_exists($root . $uri)) {
    return false;
}

require_once $root . '/index.php';
