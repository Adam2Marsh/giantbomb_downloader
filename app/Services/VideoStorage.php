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
        $this->videoRepository->updateVideoToDownloadedStatus($video->id, "FAILED");
        throw new \Exception("$video->name failed download", 1);
    }

    /**
    * Download Video from URL
    *
    * @return bool
    */
    public function downloadVideofromURL($url, $directory, $file_name)
    {
        $downloadUrl = $url."?api_key=".Config::where('name', '=', 'API_KEY')->first()->value;

        $customStorageLocation = Config::where('name', '=', 'STORAGE_LOCATION')->first()->value;

        Log::info(__METHOD__." Will create download directory if it doesn't exists");

        var_dump($customStorageLocation);

        if ($customStorageLocation == null) {
            Log::info(__METHOD__ . " Using default directory to save video as no config");
            $saveLocation = storage_path() . "/app/" . "$directory/$file_name";
            Storage::makeDirectory($directory);
        } else {
            Log::info(__METHOD__ . " Using custom directory to save video");
            Storage::disk('root')->makeDirectory($customStorageLocation . "/$directory");
            $saveLocation = Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix() .
                "$customStorageLocation/$directory/$file_name";
        }

        Log::info(__METHOD__." I've been asked to download a video from $url and save in $saveLocation");

        if (config('gb.use_wget_to_download')) {
            exec("wget --user-agent=\"@Adam2Marsh Giantbomb Downloader\" -O {$saveLocation} {$downloadUrl}", $output, $return);
            exec("chmod 777 {$saveLocation}");

            if($return != 0) {
                Log::error(__METHOD__." Video did not download successfully, output is " . $return);
                $this->deleteVideo($directory, $file_name);
            }

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
