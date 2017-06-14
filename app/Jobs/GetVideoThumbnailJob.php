<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Log;
use App\Video;
use App\Services\GetVideoDetailsService;

class GetVideoThumbnailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GetVideoDetailsService $getVideoDetailsService)
    {
        $thumbnailUrl =  $this->video->videoDetail->remote_image_path;

        Log::info(__METHOD__ . " Fetching thumbnail from $thumbnailUrl");

        $thumbnail_path = $getVideoDetailsService->downloadVideoThumbnail(
            $thumbnailUrl,
            $this->video->name
        );

        $this->video->videoDetail->local_image_path = $thumbnail_path;

        $this->video->videoDetail->save();
    }
}
