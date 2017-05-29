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

    protected $customStorageLocation;

    protected $disk;

    public function __construct()
    {
        $this->videoRepository = new VideoRepository;

//        dd(Config::where('name', '=', 'STORAGE_LOCATION')->first());

        $this->customStorageLocation = Config::where('name', '=', 'STORAGE_LOCATION')->first();

        if ($this->customStorageLocation) {
            $this->disk = "root";
            $this->customStorageLocation = $this->customStorageLocation->value;
        } else {
            $this->disk = "local";
        }
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

        $video->videoDetail->local_path = $this->downloadVideofromURL($video->url, "gb_videos", $video->file_name);
        $video->videoDetail->save();

        if ($this->checkForVideo($video->videoDetail->local_path)) {
            Log::info(__METHOD__." Video downloaded and stored $video->videoDetail->local_path");
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

        Log::info(__METHOD__." Will create download directory if it doesn't exists");

        if ($this->customStorageLocation == null) {
            Log::info(__METHOD__ . " Using default directory to save video as no config");
            $saveLocation = storage_path() . "/app/" . "$directory/$file_name";
            Storage::makeDirectory($directory);
        } else {
            Log::info(__METHOD__ . " Using custom directory to save video");
            Storage::disk('root')->makeDirectory($this->customStorageLocation . "/$directory");
            $saveLocation = Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix() .
                "$this->customStorageLocation/$directory/$file_name";
        }

        Log::info(__METHOD__." I've been asked to download a video from $url and save in $saveLocation");

        if (config('gb.use_wget_to_download')) {
            exec("wget --user-agent=\"@Adam2Marsh Giantbomb Downloader\" -O {$saveLocation} {$downloadUrl}", $output, $return);
            exec("chmod 777 {$saveLocation}");

            if ($return != 0) {
                Log::error(__METHOD__." Video did not download successfully, output is " . $return);
                $this->deleteVideo($directory, $file_name);
            }

        } else {
            Storage::put("$directory/$file_name", fopen($downloadUrl, "r"));
        }

        return $this->customStorageLocation ? $saveLocation : "$directory/$file_name";
    }


    /**
    * Has the requested video been downloaded
    *
    * @param string directory
    * @param string file_name
    */
    public function checkForVideo($video)
    {
        Log::info(__METHOD__." Checking if $video has been downloaded via disk " . $this->disk);
        if(Storage::disk($this->disk)->has($video)) {
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
    public function deleteVideo($video)
    {
        Log::info(__METHOD__." Been asked to delete $video from storage");
        Storage::disk($this->disk)->delete($video);
        Log::info(__METHOD__." $video deleted from storage");
    }

}
