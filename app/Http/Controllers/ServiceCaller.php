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

		$url=env('TEST_JSON_URL',config('gb.Website_Address'));
		$query=env('LATEST_VIDEO_QUERY',config('gb.Latest_Video_Query'));
		$apiKey= Config::where('name', '=', 'API_KEY')->first()->value;

		$dvi->UpdateVideosInDatabase($url,$query,$apiKey);
	}

}
