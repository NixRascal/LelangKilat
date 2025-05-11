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
        $schedule->command('auction:close-expired')->everyMinute();
        $schedule->call(function() {
            \App\Models\Auction::where('status','PENDING')
                ->where('start_time','<=', now())
                ->update(['status'=>'ACTIVE']);
    
            \App\Models\Auction::where('status','ACTIVE')
                ->where('end_time','<=', now())
                ->update(['status'=>'CLOSED']);
        })->everyMinute();
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
