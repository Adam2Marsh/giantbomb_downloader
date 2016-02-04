<?php

namespace App\Services;

use GuzzleHttp\Client;
use Log;

use Storage;
use App\Repositories\VideoStatusRepo;

class videoStorage
{

	protected $vsr;

	public function __construct()
	{
		$this->vsr = new \App\Repositories\VideoStatusRepo;
	}

    /**
    * Download Video from URL and Update DB
    *
    * @param VideoObject Video
    * @return null
    */
	public function saveVideo($video)
	{
		Log::info(__METHOD__." Downloading Video $video->name");
		$this->downloadVideofromURL($video->url, "gb_videos", $video->file_name);

		if ($this->checkForVideo("gb_videos", $video->file_name)) {
			Log::info(__METHOD__." Video downloaded and stored gb_videos/$video->name");
            $this->vsr->updateVideoToDownloadedStatus($video->id, "DOWNLOADED");
            return;
		}

		Log::info(__METHOD__." Video failed download");
	}

    /**
    * Download Video from URL
    *
    * @return bool
    */
	public function downloadVideofromURL($url, $directory, $file_name)
	{
		Log::info(__METHOD__." I've been asked to download a video from $url and save in $directory");
		Storage::put("$directory/$file_name", fopen($url,"r"));
	}


    /**
    * Has the requested video been downloaded
    *
    * @param string directory
    * @param string file_name
    */
    public function checkForVideo($directory, $file_name)
    {
    	Log::info(__METHOD__." Checking if video called $file_name has been downloaded");
    	if(Storage::has("$directory/$file_name")) {
    		Log::info(__METHOD__." Video has been downloaded, returning true");
    		return true;
    	}

    	Log::info(__METHOD__." Video hasn't been downloaded, returning fasle");
    	return false;
    }

    /**
    * Delete Video if on storage
    *
    * @param string directory
    * @param string file_name
    */
    public function deleteVideo($directory, $file_name)
    {
    	Log::info(__METHOD__." Been asked to delete $directory/$file_name from storage");
    	Storage::delete("$directory/$file_name");
    	Log::info(__METHOD__." $directory/$file_name deleted from storage");
    }

}