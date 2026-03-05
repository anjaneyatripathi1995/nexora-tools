<?php
/**
 * Nexora Tools — Router
 * Dispatches requests to static pages, category pages, or individual tool pages.
 */

// ─── Parse Route ──────────────────────────────────────────────────────────────
$uri       = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$base      = BASE_PATH; // '' on production, '/nexora-tools' on XAMPP
$route     = urldecode(ltrim(
    ($base !== '' && strpos($uri, $base) === 0) ? substr($uri, strlen($base)) : $uri,
    '/'
));
$route = strtolower(rtrim($route, '/'));

// ─── Static Pages ─────────────────────────────────────────────────────────────
$static = [
    ''        => 'home.php',
    'home'    => 'home.php',
    'tools'   => 'tools.php',
    'about'   => 'about.php',
    'contact' => 'contact.php',
    'privacy' => 'privacy.php',
    'terms'   => 'terms.php',
];

if (isset($static[$route])) {
    $file = ROOT . '/pages/' . $static[$route];
    file_exists($file) ? require $file : require ROOT . '/pages/home.php';
    exit;
}

// ─── Category Pages ───────────────────────────────────────────────────────────
foreach (CATEGORIES as $slug => $_) {
    if ($route === $slug || $route === $slug . '-tools') {
        $current_category = $slug;
        require ROOT . '/pages/category.php';
        exit;
    }
}

// ─── Individual Tool ──────────────────────────────────────────────────────────
$tool_file = PUBLIC_PATH . '/tools/' . $route . '/index.php';
if (file_exists($tool_file)) {
    $current_tool = find_tool($route);
    require $tool_file;
    exit;
}

// ─── 404 ──────────────────────────────────────────────────────────────────────
http_response_code(404);
require ROOT . '/pages/404.php';
