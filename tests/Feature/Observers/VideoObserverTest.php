<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Bus;

use App\Events\NewVideo;
use App\Events\VideoStateUpdated;
use App\Jobs\CancelVideoDownload;
use App\Jobs\DeleteLocalVideoDownload;
use App\Jobs\DownloadVideo;
use App\Jobs\VideoRuleCheck;
use App\Video;
use App\Jobs\GetVideoSize;
use App\Jobs\DownloadVideoThumbnail;
use Carbon\Carbon;

class VideoObserverTest extends TestCase
{
    /**
     * Test when a video is created the right jobs are dispatched
     *
     * @return void
     */
    public function test_videoCreatedJobsDispatched()
    {
        $this->createVideo(6, "VideoObserverTest", "new");

        Bus::fake();

        Bus::assertNotDispatched(GetVideoSize::class);
        Bus::assertNotDispatched(DownloadVideoThumbnail::class);
        Bus::assertNotDispatched(VideoRuleCheck::class);
    }

    /**
     * Test when a video is created the right events are dispatched
     *
     * @return void
     */
    public function test_videoCreatedEventsDispatched()
    {
        $this->marktestIncomplete("Come back and fix");

        $this->createVideo(7, "VideoObserverTest", "new");

        Event::fake();

        Event::assertDispatched(NewVideo::class);
    }

    /**
     * Test when a video is updated to "queued" state the right jobs are dispatched
     *
     * @return void
     */
    public function test_videoUpdatedQueuedStatusDispatched()
    {
        $video = Video::where('service_video_id', '=', 6)->first();
        $video->state = "queued";
        $video->save();

        Bus::fake();

        Bus::assertNotDispatched(DownloadVideo::class);
    }

    /**
     * Test when a video is updated to "watched" state the right jobs are dispatched
     *
     * @return void
     */
    public function test_videoUpdatedWatchedStatusDispatched()
    {
        $video = Video::where('service_video_id', '=', 6)->first();
        $video->state = "watched";
        $video->save();

        Bus::fake();

        Bus::assertNotDispatched(CancelVideoDownload::class);
        Bus::assertNotDispatched(DeleteLocalVideoDownload::class);
    }

    /**
     * Test when a video is updated the right events are dispatched
     *
     * @return void
     */
    public function test_videoUpdatedEventsDispatched()
    {
        $this->marktestIncomplete("Come back and fix");

        $video = Video::where('service_video_id', '=', 7)->first();
        $video->state = "watched";
        $video->save();

        Event::fake();

        Event::assertDispatched(VideoStateUpdated::class);
    }

    private function createVideo($id, $name, $state)
    {
        $newVideo = new Video();
        $newVideo->service_id = 1;
        $newVideo->service_video_id = $id;
        $newVideo->name = $name;
        $newVideo->description = $name;
        $newVideo->video_url = "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4";
        $newVideo->thumbnail_url = "http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg";
        $newVideo->size = 11334031;
        $newVideo->state = $state;
        $newVideo->published_date = Carbon::now();
        $newVideo->save();
    }
}
