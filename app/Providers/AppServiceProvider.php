<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auto-fallback: if SESSION_DRIVER=database but the sessions table is not
        // accessible (missing table, bad credentials, etc.), switch to the file
        // driver so the application can still serve pages instead of returning 500.
        if (config('session.driver') === 'database') {
            try {
                \DB::select('SELECT 1 FROM sessions LIMIT 1');
            } catch (\Throwable $e) {
                config(['session.driver' => 'file']);
            }
        }

        // Same guard for cache — if CACHE_STORE=database but DB is unavailable,
        // fall back to the array (in-memory) store so pages still render.
        if (config('cache.default') === 'database') {
            try {
                \DB::select('SELECT 1 FROM cache LIMIT 1');
            } catch (\Throwable $e) {
                config(['cache.default' => 'array']);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
