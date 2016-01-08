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
		return 'Run Update!';
	}

	public function ScheduleVideos()
	{
		return 'Bye Bye';
	}

}
