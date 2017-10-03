<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Video;
use App\Services\VideoStorage;
use App\Services\StorageService;

class DownloadVideoJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
     * @param VideoStorage $vs
     * @param StorageService $sr
     * @return void
     */
    public function handle(VideoStorage $vs, StorageService $sr)
    {
        $vs->saveVideo($this->video);
    }
}
