<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 19/02/2018
 * Time: 07:03
 */

namespace App\Repositories;

use App\Video;
use Log;

class VideoRepository
{

//    TODO Refactor to remove logic for videos and images
    /**
     * Adds a video to the database using an array to map keys from videos array to db
     *
     * @param $service_id
     * @param $videos
     * @param $mappings
     * @return int
     */
    public function addVideoToDatabase($service_id, $videos, $mappings)
    {
        Log::info("Adding new videos for service $service_id");

        $count = 0;
        foreach ($videos as $video) {
            if(!$this->checkForVideo($video[$mappings["service_video_id"]])) {
                $newVideo = new Video();
                $newVideo->service_id = $service_id;
                $newVideo->service_video_id = $video[$mappings["service_video_id"]];
                $newVideo->name = $video[$mappings["name"]];
                $newVideo->description = $video[$mappings["description"]];
                $newVideo->video_url = is_null($video[$mappings["video_url"][0]]) ? $video[$mappings["video_url"][1]] : $video[$mappings["video_url"][0]];
                $newVideo->thumbnail_url = $video["image"][$mappings["thumbnail_url"]];
                $newVideo->size = -1;
                $newVideo->state = "new";
                $newVideo->published_date = $video[$mappings["publish_date"]];
                $newVideo->save();

                $count++;
            }
        }

        Log::info("Added $count new videos for service $service_id");

        return $count;
    }

    /**
     * Checks the DB to see if the video has already been added using it's external id
     *
     * @param $id
     * @return bool
     */
    public function checkForVideo($id)
    {
        if (Video::where('service_video_id', '=', $id)->first() != null) {
            return true;
        }
        return false;
    }

    /**
     * Updates the video in DB with a new state providing an audit of what was changed
     *
     * @param $id
     * @param $state
     * @return array
     */
    public function updateVideoState($id, $state)
    {
        Log::info("Updating video $id to a status of $state");

        $video = Video::findOrFail($id);

        $oldState = $video->state;

        $video->state = $state;

        $video->save();

        return [
            "id" => $id,
            "oldState" => $oldState,
            "newState" => $state
        ];

    }
}