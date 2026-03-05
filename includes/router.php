<?php
/**
 * Nexora Tools — Router
 * Parses the request URI and loads the correct page or tool.
 */

// ─── Parse Route ──────────────────────────────────────────────────────────────
$request_uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$base_path   = BASE_PATH; // defined in config.php
$route       = urldecode(trim(
    ($base_path !== '' && strpos($request_uri, $base_path) === 0)
        ? substr($request_uri, strlen($base_path))
        : $request_uri,
    '/'
));

// Normalize: strip trailing slashes, lowercase
$route = strtolower(rtrim($route, '/'));

// ─── Static Page Map ──────────────────────────────────────────────────────────
$static_pages = [
    ''        => 'pages/home.php',
    'home'    => 'pages/home.php',
    'about'   => 'pages/about.php',
    'contact' => 'pages/contact.php',
    'privacy' => 'pages/privacy.php',
    'terms'   => 'pages/terms.php',
    'tools'   => 'pages/tools.php',
];

// ─── Category Page Map ────────────────────────────────────────────────────────
$cat_routes = [];
foreach (CATEGORIES as $slug => $cat) {
    $cat_routes[$slug . '-tools'] = $slug;
    $cat_routes[$slug]            = $slug;
}

// ─── Dispatch ─────────────────────────────────────────────────────────────────
if (array_key_exists($route, $static_pages)) {
    $page_file = ROOT . '/' . $static_pages[$route];
    if (file_exists($page_file)) {
        require $page_file;
    } else {
        // Page file missing → home
        require ROOT . '/pages/home.php';
    }
    exit;
}

// Individual tool
$tool_file = ROOT . '/tools/' . $route . '/index.php';
if (file_exists($tool_file)) {
    $current_tool = find_tool($route);
    require $tool_file;
    exit;
}

// Category listing
if (isset($cat_routes[$route])) {
    $current_category = $cat_routes[$route];
    require ROOT . '/pages/category.php';
    exit;
}

// 404
http_response_code(404);
require ROOT . '/pages/404.php';
