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
        $space = (int)0;

        foreach (Video::all() as $video) {
            if($video->state == "downloaded") {
                $space += (int)$video->size;
            }
        }

        event(new CurrentDiskSpace(human_filesize($space), round(($space/20000000000)*100)));
    }
}