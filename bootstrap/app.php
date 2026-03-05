<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role.admin' => \App\Http\Middleware\EnsureRoleIsAdmin::class,
            'admin.section' => \App\Http\Middleware\EnsureAdminCanManageSection::class,
            'admin.master' => \App\Http\Middleware\EnsureMasterAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// #region agent log
if (!function_exists('__agent_ndjson_log')) {
    function __agent_ndjson_log(string $hypothesisId, string $message, array $data = []): void
    {
        try {
            $payload = [
                'sessionId' => '6cc275',
                'runId' => env('APP_DEBUG_RUN_ID', 'pre-fix'),
                'hypothesisId' => $hypothesisId,
                'location' => 'bootstrap/app.php',
                'message' => $message,
                'data' => $data,
                'timestamp' => (int) (microtime(true) * 1000),
            ];
            @file_put_contents(base_path('debug-6cc275.log'), json_encode($payload, JSON_UNESCAPED_SLASHES) . PHP_EOL, FILE_APPEND);
        } catch (\Throwable $e) {
            // swallow
        }
    }
}
// #endregion agent log

// Shared hosting (Hostinger): allow serving from public_html without changing document root.
// Set APP_PUBLIC_PATH to the absolute path of public_html.
if (is_string(env('APP_PUBLIC_PATH')) && env('APP_PUBLIC_PATH') !== '') {
    $app->usePublicPath(env('APP_PUBLIC_PATH'));
}

// #region agent log
__agent_ndjson_log('H_PUBLIC_PATH', 'Resolved public paths', [
    'app_public_path_env' => (string) env('APP_PUBLIC_PATH', ''),
    'app_public_path_runtime' => method_exists($app, 'publicPath') ? (string) $app->publicPath() : '(no method)',
    'helper_public_path' => function_exists('public_path') ? (string) public_path() : '(no helper)',
    'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? null,
]);

try {
    $manifestInPublicPath = public_path('build/manifest.json');
    $manifestInLaravelPublic = base_path('public/build/manifest.json');
    __agent_ndjson_log('H_VITE_MANIFEST', 'Manifest paths + existence', [
        'manifest_public_path' => $manifestInPublicPath,
        'manifest_public_path_exists' => @is_file($manifestInPublicPath),
        'manifest_laravel_public' => $manifestInLaravelPublic,
        'manifest_laravel_public_exists' => @is_file($manifestInLaravelPublic),
    ]);
} catch (\Throwable $e) {
    __agent_ndjson_log('H_VITE_MANIFEST', 'Manifest probe failed', ['error' => $e->getMessage()]);
}

try {
    __agent_ndjson_log('H_DB', 'DB env + defaults (no secrets)', [
        'env_db_connection' => (string) env('DB_CONNECTION', ''),
        'config_db_default' => function_exists('config') ? (string) config('database.default') : '(no config)',
        'session_driver' => (string) env('SESSION_DRIVER', ''),
        'session_connection' => (string) env('SESSION_CONNECTION', ''),
    ]);
} catch (\Throwable $e) {
    __agent_ndjson_log('H_DB', 'DB probe failed', ['error' => $e->getMessage()]);
}
// #endregion agent log

return $app;
