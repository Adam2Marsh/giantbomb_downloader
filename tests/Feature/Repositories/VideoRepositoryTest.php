<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Repositories\VideoRepository;

class VideoRepositoryTest extends TestCase
{

    protected $videoRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->videoRepository = new VideoRepository();
    }

    /**
     * Test we can add a video to the database
     *
     * @return void
     */
    public function test_addVideoToDatabase()
    {
        Event::fake();

        $videos = [
            [
                "service_video_id" => 4,
                "name" => "addVideoToDatabase",
                "description" => "addVideoToDatabase",
                "published_date" => Carbon::now(),
                "thumbnail_url" => "http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg",
                "video_url" => "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4"
            ],
        ];

        $this->assertEquals(
            1,
            $this->videoRepository->addVideoToDatabase(
                1,
                $videos
            )
        );
    }

    /**
     * Test checking for videos in DB by service id
     */
    public function test_checkForVideo()
    {
        $this->assertTrue($this->videoRepository->checkForVideo(4));
        $this->assertFalse($this->videoRepository->checkForVideo(5));
    }

    /**
     * Test updating a video in DB works
     */
    public function test_updateVideoState()
    {
        $this->assertEquals(
            [
                "id" => 4,
                "oldState" => "watched",
                "newState" => "invalid"
            ],
            $this->videoRepository->updateVideoState(
                4,
                "invalid"
            )
        );
    }
}
