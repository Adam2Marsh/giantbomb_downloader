<?php

namespace App\Services;

use GuzzleHttp\Client;
use Log;
use Storage;
use App\Config;
use App\Repositories\VideoRepository;
use App\Repositories\StorageRepository;

class VideoStorage
{

    protected $videoRepository;

    protected $storageRepo;

    public function __construct()
    {
        $this->videoRepository = new VideoRepository;

        $this->storageRepo = new StorageRepository();
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

        $saveLocation = $this->storageRepo->returnPath() . "$directory/$file_name";

        $this->createGbVideosDirectory($directory);

        Log::info(__METHOD__." I've been asked to download a video from $url and save in $saveLocation");

        if (config('gb.use_wget_to_download')) {
            exec(
                "wget --user-agent=\"@Adam2Marsh Giantbomb Downloader\" -O {$saveLocation} {$downloadUrl}",
                $output,
                $return
            );
            exec("chmod 777 {$saveLocation}");

//            if ($return != 0) {
//                Log::error(__METHOD__." Video did not download successfully, output is " . $return);
//                $this->deleteVideo($directory, $file_name);
//            }
        } else {
            Storage::put("$directory/$file_name", fopen($downloadUrl, "r"));
        }

        return $this->storageRepo->returnDiskName() == "root" ? $saveLocation : "$directory/$file_name";
    }


    /**
    * Has the requested video been downloaded
    *
    * @param string directory
    * @param string file_name
    */
    public function checkForVideo($video)
    {
        Log::info(__METHOD__." Checking if $video has been downloaded via disk "
            . $this->storageRepo->returnDiskName());

        if (Storage::disk($this->storageRepo->returnDiskName())->has($video)) {
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
        Log::info(__METHOD__." Been asked to delete $video from storage locations");
        Storage::disk("root")->delete($video);
        Storage::disk("local")->delete($video);
        Log::info(__METHOD__." $video deleted from storage");
    }


    public function createGbVideosDirectory($directory)
    {
        if ($this->storageRepo->returnDiskName() == "root") {
            Storage::disk('root')->makeDirectory($this->storageRepo->returnPath() . "/$directory");
        } else {
            Storage::makeDirectory($directory);
        }
    }
}
