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

    // ── Verify vendor/ exists before trying to autoload ──────────────────────
    if (!file_exists(ROOT . '/vendor/autoload.php')) {
        http_response_code(503);
        echo '<!doctype html><html><head><meta charset="utf-8"><title>Setup Required</title>'
           . '<style>body{font-family:sans-serif;background:#0f172a;color:#e2e8f0;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0}'
           . '.box{background:#1e293b;border:1px solid #334155;border-radius:12px;padding:40px;max-width:600px;text-align:center}'
           . 'h1{color:#f87171;font-size:1.5rem}code{background:#0f172a;padding:4px 8px;border-radius:6px;font-size:.85rem}'
           . '</style></head><body><div class="box">'
           . '<h1>&#9888; Server Setup Incomplete</h1>'
           . '<p>PHP dependencies are missing. Run on the server:</p>'
           . '<p><code>composer install --no-dev --optimize-autoloader</code></p>'
           . '<p>If Composer is unavailable, upload the <code>vendor/</code> directory via FTP.</p>'
           . '</div></body></html>';
        exit;
    }

    if (file_exists($maintenance = ROOT . '/storage/framework/maintenance.php')) {
        require $maintenance;
    }
    require ROOT . '/vendor/autoload.php';

    try {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require_once ROOT . '/bootstrap/app.php';
        $app->handleRequest(\Illuminate\Http\Request::capture());
    } catch (\Throwable $e) {
        // Write to log (safe on any server)
        $logDir = ROOT . '/storage/logs';
        if (is_dir($logDir) && is_writable($logDir)) {
            @file_put_contents(
                $logDir . '/laravel-boot.log',
                date('[Y-m-d H:i:s] ') . get_class($e) . ': ' . $e->getMessage()
                    . ' in ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL,
                FILE_APPEND
            );
        }
        // Production: show friendly page; debug: surface the real error
        $debug = (getenv('APP_DEBUG') === 'true') || (defined('APP_DEBUG') && APP_DEBUG);
        http_response_code(500);
        if ($debug) {
            echo '<pre style="background:#1e293b;color:#f1f5f9;padding:20px;font-size:13px">'
               . '<b>' . htmlspecialchars(get_class($e)) . '</b>: '
               . htmlspecialchars($e->getMessage()) . "\n\n"
               . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        } else {
            echo '<!doctype html><html><head><meta charset="utf-8"><title>Temporarily Unavailable</title>'
               . '<style>body{font-family:sans-serif;background:#0f172a;color:#e2e8f0;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0}'
               . '.box{background:#1e293b;border:1px solid #334155;border-radius:12px;padding:40px;max-width:560px;text-align:center}'
               . 'h1{color:#60a5fa;font-size:1.4rem}a{color:#818cf8}'
               . '</style></head><body><div class="box">'
               . '<h1>&#9889; Tool temporarily unavailable</h1>'
               . '<p>We\'re looking into it. Try again shortly.</p>'
               . '<p><a href="/">&#8592; Back to Home</a></p>'
               . '</div></body></html>';
        }
    }
    exit;
}

// Flat PHP router handles everything else (home, category pages, /tools list, statics)
require ROOT . '/includes/config.php';
require ROOT . '/includes/router.php';
