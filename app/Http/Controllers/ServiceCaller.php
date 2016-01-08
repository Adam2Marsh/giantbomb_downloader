<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;

class ServiceCaller extends Controller
{
    
	public function NewVideos()
	{
		$DVI = new \App\Services\DownloadVideoInformation;

		Log::info(__METHOD__." Controller has been called to retireve all new videos and add into database");
		
		$DVI->UpdateVideosInDatabase(config('gb.Website_Address'), config('gb.Latest_Video_Query'), config('gb.api_key'));
		// $DVI->UpdateVideosInDatabase(config('gb.Test_JSON_URL'),"","");

	}

	public function ScheduleVideos()
	{
		return 'Bye Bye';
	}

}
