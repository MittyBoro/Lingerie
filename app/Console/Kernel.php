<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sitemap:generate')->daily();
        $schedule->command('payments:check')->everyFiveMinutes();
        $schedule->command('payments:clear')->dailyAt('04:20');
        $schedule->command('cart:clear')->dailyAt('04:20');
        $schedule->command('bonuses:clear')->hourly();

        $schedule->command('users:clear')->daily('04:20');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
