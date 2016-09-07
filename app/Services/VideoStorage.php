<?php

namespace App\Services;

use GuzzleHttp\Client;
use Log;
use Storage;
use App\Repositories\VideoRepository;

class VideoStorage
{

    protected $vsr;

    public function __construct()
    {
        $this->vsr = new \App\Repositories\VideoRepository;
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
        $this->downloadVideofromURL($video->url, "gb_videos", $video->file_name);

        if ($this->checkForVideo("gb_videos", $video->file_name)) {
            Log::info(__METHOD__." Video downloaded and stored gb_videos/$video->name");
            $this->vsr->updateVideoToDownloadedStatus($video->id, "SAVED");
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
        Storage::put("$directory/$file_name", fopen($url."?api_key=".config('gb.api_key'), "r"));
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

    /**
    * Return Video Storage Directory Size
    *
    * @param string directory
    */
    public function videoStorageHumanSize($directory)
    {
        Log::info(__METHOD__." Been asked to size $directory from storage");

        $directorySize = 0;

        foreach (Storage::allFiles("$directory") as $file) {
            $file_size = Storage::size($file);
            $file_size = $file_size >= 0 ? $file_size : 4*1024*1024*1024 + $file_size;
            // var_dump($file);
            // var_dump($file_size);
            $directorySize += $file_size;
        }

        return $this->humanFilesize($directorySize);
    }

    /**
    * Return Video Storage Directory Size
    *
    * @param string directory
    */
    public function videoStorageRawSize($directory)
    {
        Log::info(__METHOD__." Been asked to size $directory from storage");

        $directorySize = 0;

        foreach (Storage::allFiles("$directory") as $file) {
            $file_size = Storage::size($file);
            $file_size = $file_size >= 0 ? $file_size : 4*1024*1024*1024 + $file_size;
            // var_dump($file);
            // var_dump($file_size);
            $directorySize += $file_size;
        }

        return $directorySize;
    }

    /**
    * Return Video Storage Directory Size
    *
    * @param string directory
    */
    public function videoStorageSizeAsPercentage($directory)
    {
        Log::info(__METHOD__." Been asked to size $directory from storage as percentage");

        $directorySize = 0;

        foreach (Storage::allFiles("$directory") as $file) {
            $file_size = Storage::size($file);
            $file_size = $file_size >= 0 ? $file_size : 4*1024*1024*1024 + $file_size;
            // var_dump($file);
            // var_dump($file_size);
            $directorySize += $file_size;
        }

        return ($directorySize / 1024 / 1024) / config('gb.storage_limit') * 100 . "%";
    }

    public function getDownloadPercentageForVideo($videoPath, $videoTotalSize)
    {
        return (Storage::size($videoPath) / $videoTotalSize) * 100 . "%";
    }

    /**
    *       Return sizes readable by humans
    */
    private function humanFilesize($bytes, $decimals = 2)
    {
            $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
            $factor = floor((strlen($bytes) - 1) / 3);

            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
