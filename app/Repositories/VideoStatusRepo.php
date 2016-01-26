<?php

namespace App\Repositories;

use App\VideoStatus;
use Log;

class VideoStatusRepo
{

	public function addVideoToDatabase($videoDetails) {
        Log::info(__METHOD__." Adding Video ".$videoDetails->name." into database");

        $newVideoDownloadStatus = new VideoStatus;
        $newVideoDownloadStatus->name = $videoDetails->name;
        $newVideoDownloadStatus->gb_Id = $videoDetails->id;
        $newVideoDownloadStatus->url = $videoDetails->hd_url;
        $newVideoDownloadStatus->published_date = $videoDetails->publish_date;
        $newVideoDownloadStatus->status = 'NEW';
        $newVideoDownloadStatus->save();

        Log::info(__METHOD__." Video ".$videoDetails->name." inserted into database");
    }

    public function checkIfVideoIsInDatabase($videoName) {
        Log::info(__METHOD__." Checking if Video ".$videoName." is in database");
        $databaseResults = \App\VideoStatus::where('name', $videoName)->get();
        
        Log::info(__METHOD__." Database returned: ".print_r($databaseResults, true));

        if($databaseResults->isEmpty()) {
            Log::info(__METHOD__." No Results Found");
            return false;
        }
        else {
            Log::info(__METHOD__." Results Found");
            return true;
        }
    }
}