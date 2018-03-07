<?php

namespace App\Observers;

use App\Events\VideoStateUpdated;
use App\Jobs\CancelVideoDownload;
use App\Jobs\DeleteLocalVideoDownload;
use App\Jobs\DownloadVideo;
use App\Jobs\VideoRuleCheck;
use App\Video;
use App\Jobs\GetVideoSize;
use App\Jobs\DownloadVideoThumbnail;

class VideoObserver
{
    /**
     * Listen to the Video created event.
     *
     * @param Video $video
     * @return void
     */
    public function created(Video $video)
    {
        GetVideoSize::dispatch($video);
        DownloadVideoThumbnail::dispatch($video);
        VideoRuleCheck::dispatch($video);
    }

    /**
     * Listen to the Video created event.
     *
     * @param Video $video
     * @return void
     */
    public function updated(Video $video)
    {
        switch ($video->state) {
            case "queued":
                DownloadVideo::dispatch($video);
            break;
            case "watched":
                CancelVideoDownload::dispatch($video);
                DeleteLocalVideoDownload::dispatch($video);
            break;
        }

        event(new VideoStateUpdated($video->id, $video->state));
    }
}