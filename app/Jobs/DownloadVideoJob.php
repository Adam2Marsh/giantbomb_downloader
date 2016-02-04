<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\VideoStatus;
use App\Services\videoStorage;

class DownloadVideoJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(VideoStatus $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(videoStorage $vs)
    {
        $vs->saveVideo($this->video);
    }
}
