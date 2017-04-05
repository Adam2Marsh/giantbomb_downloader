<?php

namespace App\Observer;

use App\Video;

//Slack Notifications
use App\Notifications\NewVideoNotification;
use App\Notifications\VideoDownloadedNotification;
use App\Notifications\VideoDownloadingNotification;
use App\Notifications\VideoQueuedNotification;

//Browser Refresh via Redis and WebSocket
use App\Events\BrowserForceRefreshEvent;

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
        event(new BrowserForceRefreshEvent());
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
                $video->notify(new VideoQueuedNotification($video));
                break;
            case "DOWNLOADING":
                $video->notify(new VideoDownloadingNotification($video));
                break;
            case "DOWNLOADED":
                $video->notify(new VideoDownloadedNotification($video));
                event(new BrowserForceRefreshEvent());
                break;
        }

    }

}