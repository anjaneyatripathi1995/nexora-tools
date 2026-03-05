<?php
/**
 * Nexora Tools — Hybrid Entry Point
 *
 * Routes:
 *  - Auth / Dashboard / Admin / Livewire / /tools/{slug}  →  Laravel
 *  - Home / Category pages / /tools (listing) / static     →  Flat PHP
 *
 * Works on:
 *  XAMPP    : http://localhost/nexora-tools/          (root .htaccess → this file)
 *  Hostinger: https://tripathinexora.com/             (public_html/ = this directory)
 */

// PHP built-in dev server: serve real static files directly
if (PHP_SAPI === 'cli-server') {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if ($uri !== '/' && is_file(__DIR__ . $uri)) {
        return false;
    }
}

define('ROOT',        dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('APP_VERSION', '2.0.0');

// ── Detect clean route (strip base path) ──────────────────────────────────────
$_raw_uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$_raw_uri = str_replace('\\', '/', $_raw_uri);

// PHP built-in server (artisan serve): SCRIPT_NAME === REQUEST_URI — no base to strip.
// Apache (XAMPP/Hostinger): SCRIPT_NAME = /base/public/index.php — strip /base.
if (PHP_SAPI === 'cli-server') {
    $_path = $_raw_uri;
} else {
    $_script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $_base   = rtrim(dirname($_script), '/');
    $_base   = preg_replace('#/public$#i', '', $_base); // remove trailing /public on XAMPP
    $_path   = $_raw_uri;
    if ($_base !== '' && $_base !== '.' && str_starts_with($_raw_uri, $_base)) {
        $_path = substr($_raw_uri, strlen($_base));
    }
}
$_path = '/' . ltrim($_path, '/');

// ── Route prefix check: is this a Laravel-handled route? ─────────────────────
$_laravel_exact  = ['/login', '/register', '/logout', '/forgot-password',
                    '/reset-password', '/verify-email', '/confirm-password',
                    '/profile', '/dashboard', '/up'];
$_laravel_prefix = ['/admin', '/livewire', '/tools/', '/saved-items'];

$_use_laravel = false;

foreach ($_laravel_exact as $exact) {
    if (rtrim($_path, '/') === $exact) { $_use_laravel = true; break; }
}
if (!$_use_laravel) {
    foreach ($_laravel_prefix as $prefix) {
        if (str_starts_with($_path, $prefix)) { $_use_laravel = true; break; }
    }
}

// ── Dispatch ─────────────────────────────────────────────────────────────────
if ($_use_laravel) {
    define('LARAVEL_START', microtime(true));

    if (file_exists($maintenance = ROOT . '/storage/framework/maintenance.php')) {
        require $maintenance;
    }
    require ROOT . '/vendor/autoload.php';

    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once ROOT . '/bootstrap/app.php';
    $app->handleRequest(\Illuminate\Http\Request::capture());
    exit;
}

// Flat PHP router handles everything else (home, category pages, /tools list, statics)
require ROOT . '/includes/config.php';
require ROOT . '/includes/router.php';
