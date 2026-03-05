<?php
// Router for PHP built-in server when serving from project root (Hostinger-like).
// Usage: php -S 127.0.0.1:8001 server-root.php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));

// Serve existing files directly (e.g. /build/*, /images/*)
if ($uri !== '/' && file_exists(__DIR__.$uri)) {
    return false;
}

require __DIR__.'/index.php';

