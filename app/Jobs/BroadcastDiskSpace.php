<?php

namespace App\Jobs;

use App\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Events\CurrentDiskSpace;
use Log;
use Storage;

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
     * @return void
     */
    public function handle()
    {
        Log::info("Checking disk space");

        $time = 0;

        while($time < 55) {
            $space = $this->calculateDiskSpace();
            event(new CurrentDiskSpace(human_filesize($space), round(($space / 20000000000) * 100)));
            $time+=5;
            sleep(5);
        }
    }

    public function calculateDiskSpace()
    {
        $space = (int)0;

        foreach (Storage::allFiles("videos") as $file) {
            Log::info("$file is " . Storage::size($file));
            $space += Storage::size($file);
        }

        return $space;
    }
}
