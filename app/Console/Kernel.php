<?php

namespace App\Console;

use App\Services\DownloadVideoInformation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Log;
use App\Config;

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
            $dvi = new DownloadVideoInformation;

            Log::info(__METHOD__." Schedule has been called to retrieve all new videos and insert into database");

            $url=config('gb.api_address');

            $query=config('gb.api_query') . config('gb.max_videos_to_grab_api');

            $apiKey= Config::where('name', '=', 'API_KEY')->first()->value;

            $dvi->UpdateVideosInDatabase($url, $query, $apiKey);
        })->hourly();
    }
}
