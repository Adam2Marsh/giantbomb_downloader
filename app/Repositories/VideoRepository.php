<?php

namespace App\Repositories;

use App\Video;
use App\VideoDetails;
use Log;
use App\Notifications\NewVideoNotification;

class VideoRepository
{

    /**
    * Add video into database
    *
    * @param VideoDetails Object
    */
	public function addVideoToDatabase($video, $fileSize, $thumbnail_path)
    {
        Log::info(__METHOD__." Adding Video ".$video->name." into database");

        $newVideoDownloadStatus = new Video;
        $newVideoDownloadStatus->name = $video->name;

        $videoFilename = snake_case(removeSpecialCharactersFromString($video->name)).".mp4";

        $newVideoDownloadStatus->file_name = $videoFilename;
        $newVideoDownloadStatus->gb_Id = $video->id;
        $newVideoDownloadStatus->url = $video->hd_url;
        $newVideoDownloadStatus->published_date = $video->publish_date;
        $newVideoDownloadStatus->status = 'NEW';
        $newVideoDownloadStatus->save();

        $newVideoDetails = new VideoDetails([
                'local_path' => "gb_videos/$videoFilename",
                'file_size' => $fileSize,
                'image_path' => $thumbnail_path,
                ]);
        $newVideoDownloadStatus->videoDetail()->save($newVideoDetails);

        Log::info(__METHOD__." Video ".$video->name." inserted into database");

        $newVideoDownloadStatus->notify(new NewVideoNotification($newVideoDownloadStatus));

        return $newVideoDownloadStatus;
    }

    /**
    * Check if video is in database
    *
    * @param string VideoName
    */
    public function checkIfVideoIsInDatabase($videoName)
    {
        Log::info(__METHOD__." Checking if Video ".$videoName." is in database");
        $databaseResults = \App\Video::where('name', $videoName)->get();

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
        $video = Video::findOrFail($id);

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
        $video = Video::findOrFail($id);

        Log::info(__METHOD__." Been asked to update video->name to $status status");
        $video->status = $status;
        $video->save();
        Log::info(__METHOD__." video->name updated to $status status");
    }


    /**
    * Return the size of any videos downloading
    * @return string
    */
    public function returnVideosDownloading()
    {
        return Video::where('status', '=', 'DOWNLOADING')->get();
    }

}
