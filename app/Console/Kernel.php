<?php

namespace App\Console;

use App\Jobs\DeleteTempFiles;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        $schedule->command('bookmark:clear')->daily();
        $schedule->job(new DeleteTempFiles)->daily();
        // $schedule->command('inspire')->hourly();
        // $schedule->command('telescope:prune')->daily();


        if(env('BACKUP_ENABLED')){
            $schedule->command('backup:clean')->daily()->at('01:00');
            $schedule->command('backup:run')->hourly();
        }

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
