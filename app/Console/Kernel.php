<?php

namespace App\Console;

//use App\Jobs\CheckEquipmentTestDueDates;
use App\Jobs\CheckEquipmentTestDueDates;
use Database\Seeders\DemodataSeeder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      //  $schedule->job(new CheckEquipmentTestDueDates())->daily();
      //  $schedule->command('testware:demoseeder --force')->everyMinute()->withoutOverlapping(5);
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
