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

// ── Public path resolution ────────────────────────────────────────────────────
// Priority 1: explicit APP_PUBLIC_PATH env (advanced override)
// Priority 2: PUBLIC_PATH constant defined in public/index.php (auto — works on
//             both XAMPP and Hostinger without any manual config)
// Priority 3: Laravel default (base_path('public')) — works for artisan serve
if (is_string(env('APP_PUBLIC_PATH')) && env('APP_PUBLIC_PATH') !== '') {
    $app->usePublicPath(env('APP_PUBLIC_PATH'));
} elseif (defined('PUBLIC_PATH') && is_dir(PUBLIC_PATH)) {
    $app->usePublicPath(PUBLIC_PATH);
}

return $app;
