<?php
// Simple router for PHP's built-in server to mimic Apache rewrite rules.
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$root = __DIR__;

// Serve existing files (assets) directly.
if ($uri !== '/' && file_exists($root . $uri)) {
    return false;
}

// Fall back to the Laravel front controller.
require_once $root . '/index.php';
