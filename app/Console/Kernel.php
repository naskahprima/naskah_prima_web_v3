<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        
        // Maintenance cleanup setiap hari jam 2 pagi
        $schedule->command('maintenance:cleanup')
            ->dailyAt('02:00')
            ->appendOutputTo(storage_path('logs/maintenance.log'));

        // Regenerate sitemap setiap minggu
        $schedule->command('sitemap:generate')
            ->weekly()
            ->sundays()
            ->at('03:00');

        // Clear cache setiap minggu
        $schedule->command('cache:clear')
            ->weekly()
            ->mondays()
            ->at('04:00');

        // Optimize database setiap bulan
        $schedule->command('maintenance:cleanup')
            ->monthlyOn(1, '03:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
