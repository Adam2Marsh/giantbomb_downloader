<?php

namespace App\Console;

use App\Services\DownloadVideoInformation;
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
            $dvi = new DownloadVideoInformation;

            Log::info(__METHOD__." Schedule has been called to retrieve all new videos and insert into database");

            $url=env('TEST_JSON_URL',config('gb.Website_Address'));
            $query=env('LATEST_VIDEO_QUERY',config('gb.Latest_Video_Query'));
            $apiKey= Config::where('name', '=', 'API_KEY')->first()->value;

            $dvi->UpdateVideosInDatabase($url,$query,$apiKey);
        })->hourly();

    }
}
