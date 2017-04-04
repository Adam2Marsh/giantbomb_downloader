<?php

namespace App\Services;

use GuzzleHttp\Client;
use Log;
use Storage;
use App\Config;
use App\Repositories\VideoRepository;

class VideoStorage
{

    protected $videoRepository;

    public function __construct()
    {
        $this->videoRepository = new VideoRepository;
    }

    /**
    * Download Video from URL and Update DB
    *
    * @param  VideoObject Video
    * @return null
    */
    public function saveVideo($video)
    {
        Log::info(__METHOD__." Downloading Video $video->name");
        $this->videoRepository->updateVideoToDownloadedStatus($video->id, "DOWNLOADING");
        $this->downloadVideofromURL($video->url, "gb_videos", $video->file_name);

        if ($this->checkForVideo("gb_videos", $video->file_name)) {
            Log::info(__METHOD__." Video downloaded and stored gb_videos/$video->name");
            $this->videoRepository->updateVideoToDownloadedStatus($video->id, "DOWNLOADED");
            return;
        }

        Log::error(__METHOD__." Video failed download");
        throw new Exception("$video->name failed download", 1);

    }

    /**
    * Download Video from URL
    *
    * @return bool
    */
    public function downloadVideofromURL($url, $directory, $file_name)
    {
        Log::info(__METHOD__." I've been asked to download a video from $url and save in $directory");

        $downloadUrl = $url."?api_key=".Config::where('name', '=', 'API_KEY')->first()->value;
        $saveLocation = "$directory/$file_name";

        if(config('gb.use_wget_to_download')) {
            $saveLocation = storage_path() . "/app/" . $saveLocation;
            $output = `wget -O {$saveLocation} {$downloadUrl}`;
        } else {
            Storage::put("$directory/$file_name", fopen($downloadUrl, "r"));
        }
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
        if (Storage::has("$directory/$file_name")) {
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
