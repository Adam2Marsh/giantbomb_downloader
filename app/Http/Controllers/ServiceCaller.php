<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;

class ServiceCaller extends Controller
{
    
	public function newVideos()
	{
		$dvi = new \App\Services\DownloadVideoInformation;

		Log::info(__METHOD__." Controller has been called to retireve all new videos and add into database");
		
		// $dvi->UpdateVideosInDatabase(config('gb.Website_Address'), config('gb.Latest_Video_Query'), config('gb.api_key'));

		$url=env('TEST_JSON_URL',config('gb.Website_Address'));
		$query=env('LATEST_VIDEO_QUERY',config('gb.Latest_Video_Query'));
		$apiKey=env('GB_API_KEY',config('gb.api_key'));

		$dvi->UpdateVideosInDatabase($url,$query,$apiKey);
	}

	public function ScheduleVideos()
	{
		return 'Bye Bye';
	}

}
