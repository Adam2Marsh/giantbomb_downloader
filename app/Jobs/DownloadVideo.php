<?php

namespace App\Jobs;

use App\Services\VideoService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use Storage;

use Symfony\Component\Process\Process;
use App\Services\DiskService;
use App\Setting;

class DownloadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    protected $path;

    protected $videoService;

    protected $maxStorageLimit;

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

        $this->videoService = new VideoService($this->video->service->name);

        $this->maxStorageLimit = Setting::where('key', '=', 'storage_limit')->first()->value;
    }

    /**
     * Execute the job.
     *
     * @param DiskService $diskService
     * @return void
     * @throws \Exception
     */
    public function handle(DiskService $diskService)
    {
        if(($diskService->calculateDiskSpace() + $this->video->size) < $this->maxStorageLimit) {
            Log::info("Downloading video to " . $this->path . "/" . localFilename($this->video->name) . ".mp4");

            $this->video->state = "downloading";

            $this->video->save();

            if(env('TEST_DOWNLOAD', 0) == 1) {

                $command = "cd $this->path && pwd && dd " .
                    "if=/dev/zero " .
                    "of=" . localFilename($this->video->name) . ".mp4 " .
                    "bs=1m count=" . (round($this->video->size / 1024 / 1024));

                $process = new Process($command);

                $process->run();
            } else {
                $this->videoService->downloadVideo(
                    $this->video->video_url,
                    $this->path . "/" . localFilename($this->video->name) . ".mp4"
                );
            }

            $this->video->state = "downloaded";

            $this->video->save();
        } else {
            Log::info($this->video->name . " download has been delayed as not enough room on disk");
            DownloadVideo::dispatch($this->video)->delay(now()->addMinute(config('gb.video_download_retry_time')));
        }
    }

    public function failed(\Exception $e = null) {
        Log::info("Failed to download " . $this->video->name);

        $this->video->state = "failed";

        $this->video->save();
    }
}
