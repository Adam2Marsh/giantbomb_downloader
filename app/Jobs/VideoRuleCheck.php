<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Rule;
use App\Repositories\VideoRepository;
use Log;

class VideoRuleCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VideoRepository $videoRepository)
    {
        Log::info("Checking if " . $this->video->name . "matches any rules");
        foreach (Rule::all() as $rule) {
            if($rule->enabled) {
                if(preg_match("/".$rule->rule."/", $this->video->name)) {
                    Log::info($this->video->name . " matched rule " . $rule->rule . " so adding to download queue");
                    $videoRepository->updateVideoState($this->video->id, "queued");
                }
            }
        }
    }
}
