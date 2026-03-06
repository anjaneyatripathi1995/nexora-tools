<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateSitemap::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Regenerate sitemap weekly; adjust as needed.
        $schedule->command('seo:generate-sitemap')->weekly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
