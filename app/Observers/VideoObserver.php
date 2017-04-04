<?php

namespace App\Observer;


use App\Video;
use App\Config;

//Slack Notifications
use App\Notifications\NewVideoNotification;
use App\Notifications\VideoDownloadedNotification;

//Browser Refresh via Redis and WebSocket
use App\Events\VideoDownloadedEvent;

class VideoObserver
{

    /**
     * Listen to the Video created event.
     *
     * @param  Video  $video
     * @return void
     */
    public function created(Video $video)
    {
        event(new VideoDownloadedEvent());
        $video->notify(new NewVideoNotification($video));
    }


    /**
     * Listen to the Video updated event.
     *
     * @param  Video  $video
     * @return void
     */
    public function updated(Video $video)
    {
        switch ($video->status) {
            case "QUEUED":
//                $video->notify(ne)
                break;

            case "DOWNLOADING":

                break;

            case "DOWNLOADED":
                $video->notify(new VideoDownloadedNotification($video));
                break;
        }
    }

}