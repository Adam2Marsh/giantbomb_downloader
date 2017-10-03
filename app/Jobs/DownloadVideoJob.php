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
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @param VideoStorage $vs
     * @param StorageService $storageService
     */
    public function handle(VideoStorage $vs, StorageService $storageService)
    {
        if($storageService->spaceLeftOnDiskAfterDownloadCheck($this->video->videoDetail()->file_size)) {
            $vs->saveVideo($this->video);
        };
    }
}
