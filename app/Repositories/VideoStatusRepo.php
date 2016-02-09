<?php

namespace App\Repositories;

use App\VideoStatus;
use App\VideoDetails;
use Log;

class VideoStatusRepo
{

    /**
    * Add video into database
    *
    * @param VideoDetails Object
    */
	public function addVideoToDatabase($video, $details)
    {
        Log::info(__METHOD__." Adding Video ".$video->name." into database");

        $newVideoDownloadStatus = new VideoStatus;
        $newVideoDownloadStatus->name = $video->name;

        $videoFilename = $this->removeSpecialCharactersFromString($video->name).".mp4";

        $newVideoDownloadStatus->file_name = $videoFilename;
        $newVideoDownloadStatus->gb_Id = $video->id;
        $newVideoDownloadStatus->url = $video->hd_url;
        $newVideoDownloadStatus->published_date = $video->publish_date;
        $newVideoDownloadStatus->status = 'NEW';
        $newVideoDownloadStatus->save();

        $newVideoDetails = new VideoDetails([
                'local_path' => "gb_videos/$videoFilename",
                'file_size' => "",
                'image_path' => "",
                ]);
        $newVideoDownloadStatus->videoDetail()->save($newVideoDetails);

        Log::info(__METHOD__." Video ".$video->name." inserted into database");
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
    public function updateVideoToDownloadedStatus($id, $status)
    {
        $video = VideoStatus::findOrFail($id);

        Log::info(__METHOD__." Been asked to update video->name to $status status");
        $video->status = $status;
        $video->save();
        Log::info(__METHOD__." video->name updated to $status status");
    }

    /**
    * Remove Special Characters for filename
    * @return string
    */
    public function removeSpecialCharactersFromString($string)
    {
        $removeChars = [
            " " => "_",
            "/" => "-",
            ":" => "",
        ];

        return str_replace(array_keys($removeChars), array_values($removeChars), $string);
    }

}