<?php

namespace App\Repositories;

use App\VideoStatus;
use Log;

class VideoStatusRepo
{

    /**
    * Add video into database
    *
    * @param VideoDetails Object
    */
	public function addVideoToDatabase($videoDetails) 
    {
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

    /**
    * Check if video is in database
    *
    * @param string VideoName
    */
    public function checkIfVideoIsInDatabase($videoName) 
    {
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

    /**
    * Remove video from database
    *
    * @param interger id
    */
    public function deleteVideoFromDatabase($id) 
    {
        $video = VideoStatus::findOrFail($id);

        Log::info(__METHOD__." Been asked to delete the following video $video->name");
        $video->delete();
        Log::info(__METHOD__." Video deleted");

        return $video->name;
    }

    /**
    * Update Video Status in Database to Downloaded
    *
    * @param interger id
    */
    public function updateVideoToDownloadedStatus($id)
    {
        $video = VideoStatus::findOrFail($id);

        Log::info(__METHOD__." Been asked to update video->name to downloaded status");
        $video->status = "DOWNLOADED";
        $video->save();
        Log::info(__METHOD__." video->name updated to downloaded status");
    }

}