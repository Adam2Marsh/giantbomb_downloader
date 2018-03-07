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
    protected $videoService;

    /**
     * Create a new job instance.
     *
     * @param $video
     */
    public function __construct($video)
    {
        $this->video = $video;
        $this->videoService = new VideoService($this->video->service->name);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = localFilename($this->video->name) . ".png";
        $this->video->thumbnail_local_url = $this->videoService->downloadThumbnail($this->video, $filename);
        $this->video->save();
    }
}
