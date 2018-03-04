<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service;
use App\Jobs\DownloadVideoThumbnail;

class VideosDownloadThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videos:downloadThumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch new videos from an or all service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $services = Service::all();

        foreach ($services as $service) {
            foreach ($service->videos as $video) {
                $this->info($video->name);
//                $this->info($videoService->downloadThumbnail($video));
                DownloadVideoThumbnail::dispatch($video);
            }
        }
    }
}
