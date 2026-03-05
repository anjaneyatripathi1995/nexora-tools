<?php
/**
 * Nexora Tools — Web Entry Point
 *
 * On XAMPP    : http://localhost/nexora-tools/  (via root .htaccess → this file)
 * On Hostinger: https://tripathinexora.com/     (public/ contents uploaded to public_html/)
 * On CLI      : php -S localhost:8000 server.php  OR  php artisan serve
 *
 * ROOT        = project root (parent of public/)
 * PUBLIC_PATH = this directory (public/)
 */

// PHP built-in dev server: serve real static files before routing
// Works when doc root is set to public/ (php -S localhost:8000 -t public OR php artisan serve)
if (PHP_SAPI === 'cli-server') {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if ($uri !== '/' && is_file(__DIR__ . $uri)) {
        return false; // built-in server serves the file from public/ directly
    }
}

define('ROOT',        dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('APP_VERSION', '2.0.0');

require ROOT . '/includes/config.php';
require ROOT . '/includes/router.php';
