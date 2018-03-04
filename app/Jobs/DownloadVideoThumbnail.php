<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Services\VideoService;
use Log;

class DownloadVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     *
     * @param $video
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VideoService $videoService)
    {
        $filename = localFilename($this->video->name) . ".png";

        if(!thumbnailDownloaded($filename)){
            $this->video->thumbnail_local_url = $videoService->downloadThumbnail($this->video, $filename);
            $this->video->save();
        } else {
            Log::info("Thumbnail already exists for " . $this->video->name);
        }
    }
}
