<?php

namespace App\Console;

use App\Console\Commands\BatchRefund;
use App\Console\Commands\paylineCheck;
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
        Commands\CreateFundation::class,
        Commands\CreateService::class,
        Commands\ListService::class,
        Commands\EnableService::class,
        BatchRefund::class,
        paylineCheck::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
