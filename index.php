<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Hostinger shared hosting: document root = public_html = project root; assets live at /build, /images.
define('LARAVEL_PUBLIC_PATH_IS_ROOT', true);

// #region agent log
if (!function_exists('__agent_ndjson_log_root')) {
    function __agent_ndjson_log_root(string $hypothesisId, string $message, array $data = []): void
    {
        try {
            $payload = [
                'sessionId' => '6cc275',
                'runId' => getenv('APP_DEBUG_RUN_ID') ?: 'pre-fix',
                'hypothesisId' => $hypothesisId,
                'location' => 'index.php',
                'message' => $message,
                'data' => $data,
                'timestamp' => (int) (microtime(true) * 1000),
            ];
            @file_put_contents(__DIR__ . '/debug-6cc275.log', json_encode($payload, JSON_UNESCAPED_SLASHES) . PHP_EOL, FILE_APPEND);
        } catch (\Throwable $e) {
            // swallow
        }
    }
}

if ((getenv('APP_AGENT_DEBUG') ?: '') === '1') {
    __agent_ndjson_log_root('H_ENTRYPOINT', 'Root index.php hit', [
        'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
        'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? null,
        'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? null,
    ]);
}
// #endregion agent log

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

