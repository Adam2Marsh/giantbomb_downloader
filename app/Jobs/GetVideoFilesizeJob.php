<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Log;
use App\Video;
use App\Config;
use App\Services\GetVideoDetailsService;

class GetVideoFilesizeJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

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
     * @param GetVideoDetailsService $getVideoDetailsService
     */
    public function handle(GetVideoDetailsService $getVideoDetailsService)
    {
        Log::info(__METHOD__ . " Fetching video size for " . $this->video->url);

        $apiKey= Config::where('name', '=', 'API_KEY')->first()->value;

        $fileSize = $getVideoDetailsService->getVideoFileSize($this->video->url."?api_key=$apiKey");

        $this->video->videoDetail->file_size = $fileSize;

        $this->video->videoDetail->save();
    }
}
