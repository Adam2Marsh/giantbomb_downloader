<?php

namespace App\Observers;

use App\Video;
use App\Jobs\GetVideoSize;
use App\Jobs\DownloadVideoThumbnail;

class VideoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(Video $video)
    {
        GetVideoSize::dispatch($video);
        DownloadVideoThumbnail::dispatch($video);
    }
}