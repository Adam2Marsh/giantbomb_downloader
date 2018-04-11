<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use Storage;

use Symfony\Component\Process\Process;
use App\Services\DiskService;

class DownloadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
        Storage::makeDirectory("videos/" . $video->service->name);

        $this->path = storage_path("app/videos/" . $video->service->name);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DiskService $diskService)
    {
        if(($diskService->calculateDiskSpace() + $this->video->size) < config('gb.disk_space')) {
            Log::info("Downloading video to " . $this->path . "/" . localFilename($this->video->name) . ".mp4");

            $this->video->state = "downloading";

            $this->video->save();

            $command = "cd $this->path && pwd && dd " .
                "if=/dev/zero " .
                "of=" . localFilename($this->video->name) . ".mp4 " .
                "bs=1m count=" . (round($this->video->size / 1024 / 1024));

            $process = new Process($command);

            $process->run();

            $this->video->state = "downloaded";

            $this->video->save();
        } else {
            Log::info($this->video->name . " download has been delayed as not enough room on disk");
            DownloadVideo::dispatch($this->video)->delay(now()->addMinute(config('gb.video_download_retry_time')));
        }
    }
}
