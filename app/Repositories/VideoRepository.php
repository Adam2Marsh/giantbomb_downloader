<?php

namespace App\Repositories;

use App\Video;
use App\VideoDetails;
use Log;

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

        $videoFilename = $this->covertTitleToFileName($video->name);

        $newVideoDownloadStatus->file_name = $videoFilename;
        $newVideoDownloadStatus->gb_Id = $video->id;
        $newVideoDownloadStatus->url = $this->findHighestQualityVideo($video);
        $newVideoDownloadStatus->published_date = $video->publish_date;
        $newVideoDownloadStatus->status = 'NEW';
        $newVideoDownloadStatus->save();

        $newVideoDetails = new VideoDetails([
                'local_path' => "app/gb_videos/$videoFilename",
                'file_size' => $fileSize,
                'image_path' => $thumbnail_path,
                ]);
        $newVideoDownloadStatus->videoDetail()->save($newVideoDetails);

        Log::info(__METHOD__." Video ".$video->name." inserted into database");

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

    /**
     * Get the highest quality video in this order hd, high and then low
     * @param $video
     * @return string
     */
    public function findHighestQualityVideo($video)
    {
        if($video->hd_url != null) {
            return $video->hd_url;
        }

        if($video->high_url != null) {
            return $video->high_url;
        }

        if($video->low_url != null) {
            return $video->low_url;
        }
    }

    /**
     * Will Convert Video Title to a correct filename
     * @param $videoTitle
     * @return string
     */
    public function covertTitleToFileName($videoTitle)
    {
        return snake_case(removeSpecialCharactersFromString($videoTitle)).".mp4";
    }

}
