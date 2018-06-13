<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Service;
use Log;

class FetchNewVideosForAllServices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $services;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->services = Service::all();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Fetching new videos for all services");
        foreach ($this->services as $service) {
            if($service->enabled) {
                Log::info("Fetching new videos for " . $service->name . " service");

                $newService = "\\App\Services\Video\\" . $service->name . "VideoService";

                $service = new $newService;

                $service->fetchLatestVideosFromApi();
            }
        }
    }
}
