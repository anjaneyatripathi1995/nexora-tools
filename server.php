<?php
/**
 * Nexora Tools — PHP Built-in Server Router
 * Usage: php -S localhost:8000 server.php
 *
 * 'return false' does NOT work here because doc root is the project root,
 * not public/. Static files must be served manually via readfile().
 */
$uri    = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$public = __DIR__ . '/public';
$file   = $public . $uri;

// Serve static files from public/ directory
if ($uri !== '/' && is_file($file)) {
    $mime = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'svg'   => 'image/svg+xml',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'otf'   => 'font/otf',
        'json'  => 'application/json',
        'xml'   => 'application/xml',
        'txt'   => 'text/plain',
        'gif'   => 'image/gif',
        'mp4'   => 'video/mp4',
    ];
    $ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
    header('Content-Type: ' . ($mime[$ext] ?? 'application/octet-stream'));
    header('Cache-Control: public, max-age=86400');
    readfile($file);
    exit;
}

// Route all PHP requests through public/index.php
require $public . '/index.php';
