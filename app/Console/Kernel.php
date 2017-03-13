<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Log;
use Config;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
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


        $schedule->call(function () {
            $DVI = new \App\Services\DownloadVideoInformation;
            $apiKey= Config::where('name', '=', 'API_KEY')->first()->value;
            Log::info(__METHOD__." Schedule has been called to retireve all new videos and add into database");
            $DVI->UpdateVideosInDatabase(config('gb.Website_Address'), config('gb.Latest_Video_Query'), $apiKey);
        })->hourly();

    }
}
