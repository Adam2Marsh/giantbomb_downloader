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
    public function handle()
    {
        Log::info("Downloading video to " . $this->path . "/" .  localFilename($this->video->name) . ".mp4");

//        $command = "mkfile -n ".
//            $this->video->size . "b  " .
//            $this->path . "/" .  localFilename($this->video->name) . ".mp4";

//        $command = "cd /Users/adam2marsh/Sites/giantbomb_downloader/storage/app/videos/Giantbomb && dd if=/dev/zero of=output.dat bs=24m count=1";

        $command = "cd $this->path && pwd && dd " .
            "if=/dev/zero " .
            "of=" . localFilename($this->video->name) . ".mp4 " .
            "bs=1m count=" . (round($this->video->size / 1024 / 1024));

        $process = new Process($command);

        $process->run();

        Log::info((round($this->video->size / 1024 / 1024)));

        $this->video->state = "downloaded";

        $this->video->save();
    }
}
