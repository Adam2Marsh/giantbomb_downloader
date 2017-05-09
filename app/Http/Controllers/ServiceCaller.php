<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\DownloadVideoInformation;
use App\Config;
use Log;

class ServiceCaller extends Controller
{

    public function newVideos()
    {
        $dvi = new DownloadVideoInformation;

        Log::info(__METHOD__." Controller has been called to retrieve all new videos and insert into database");

        $url=config('gb.api_address');

        $query=config('gb.api_query') . config('gb.max_videos_to_grab_api');

        $apiKey= Config::where('name', '=', 'API_KEY')->first()->value;

        $dvi->UpdateVideosInDatabase($url, $query, $apiKey);
    }
}
