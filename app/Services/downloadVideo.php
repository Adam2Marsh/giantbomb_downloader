<?php

namespace App\Services;

use GuzzleHttp\Client;
use Log;

use Storage;

class downloadVideo
{

    /**
    * Download Video from URL
    * @return bool
    */
	public function downloadVideofromURL($url, $directory, $name)
	{
		Log::info(__METHOD__." I've been asked to download a video from $url and save in $directory");
		Storage::put("$directory/$name", fopen($url,"r"));
	}


    /**
    * Has the requested video been downloaded
    * @return bool
    */
    public function checkForDownloadedVideo($directory, $name)
    {
    	Log::info(__METHOD__." Checking if video called $name has been downloaded");
    	if(Storage::has("$directory/$name")) {
    		Log::info(__METHOD__." Video has been downloaded, returning true");
    		return true;
    	}

    	Log::info(__METHOD__." Video hasn't been downloaded, returning fasle");
    	return false;
    }
}