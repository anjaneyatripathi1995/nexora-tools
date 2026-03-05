<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentDebugMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ((string) env('APP_AGENT_DEBUG', '0') !== '1') {
            return $next($request);
        }

        $this->log('H_HTTP', 'HTTP request start', [
            'method' => $request->getMethod(),
            'path' => $request->getPathInfo(),
            'full_url' => $request->fullUrl(),
            'route_name' => optional($request->route())->getName(),
            'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? null,
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? null,
        ]);

        $this->log('H_PUBLIC_PATH', 'Public path + manifest check', [
            'app_public_path_env' => (string) env('APP_PUBLIC_PATH', ''),
            'public_path' => public_path(),
            'manifest_path' => public_path('build/manifest.json'),
            'manifest_exists' => is_file(public_path('build/manifest.json')),
        ]);

        $this->log('H_DB', 'DB defaults (no secrets)', [
            'env_db_connection' => (string) env('DB_CONNECTION', ''),
            'config_db_default' => (string) config('database.default'),
            'session_driver' => (string) env('SESSION_DRIVER', ''),
            'session_connection' => (string) env('SESSION_CONNECTION', ''),
        ]);

        return $next($request);
    }

    private function log(string $hypothesisId, string $message, array $data = []): void
    {
        try {
            $payload = [
                'sessionId' => '6cc275',
                'runId' => env('APP_DEBUG_RUN_ID', 'pre-fix'),
                'hypothesisId' => $hypothesisId,
                'location' => 'app/Http/Middleware/AgentDebugMiddleware.php',
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

