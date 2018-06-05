<?php

namespace App\Services;

use Storage;
use App\Video;
use Log;

class DiskService
{

    /**
     * Calculates Total Disk Space Used
     *
     * @return int
     */
    public function calculateDiskSpace()
    {
        $space = (int)0;

        foreach (Storage::allFiles("videos") as $file) {
//            Log::info("$file is " . Storage::size($file));
            $space += Storage::size($file);
        }

        return $space;
    }

    /**
     * Returns download percentage for any videos which are downloading
     *
     * @return array
     */
    public function videosDownloadingProgress()
    {
        $downloading = [];

        foreach (Video::where('state', '=', 'downloading')->get() as $video) {
            array_push($downloading,
                [
                    "id" => $video->id,
                    "download_percentage" => $video->downloaded_percentage
                ]);
        }

        return $downloading;
    }

}