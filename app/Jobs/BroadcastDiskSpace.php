<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Events\CurrentDiskSpace;
use App\Services\DiskService;
use Log;

class BroadcastDiskSpace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param DiskService $diskService
     */
    public function handle(DiskService $diskService)
    {
        Log::info("Checking disk space");

        $time = 0;

        while($time < 55) {
            $space = $diskService->calculateDiskSpace();
            $downloading = $diskService->videosDownloadingProgress();

            event(new CurrentDiskSpace(
                human_filesize($space),
                round(($space / 20000000000) * 100),
                $downloading)
            );

            $time+=5;
            sleep(5);
        }
    }
}
