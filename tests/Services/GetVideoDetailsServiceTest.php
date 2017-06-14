<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetVideoDetailsServiceTest extends TestCase
{

    protected $getVideoDetails;

    public function setup()
    {
        $this->getVideoDetails = new \App\Services\GetVideoDetailsService;
        parent::setUp();
    }

    public function test_downloadVideoThumbnail()
    {
        $path = $this->getVideoDetails->downloadVideoThumbnail(
            "http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg"
            , "Just Testing SomethingWith Spaces"
        );

        $this->assertEquals("video_thumbnails/just_testing_something_with_spaces.png", $path);
    }

    public function test_getVideoFileSize()
    {
        $fileSize = $this->getVideoDetails->getVideoFileSize(env('TEST_VIDEO_URL',""));
        $this->assertRegexp('/\d+/', $fileSize);
    }

    public function test_getVideoFileSize_404Response()
    {
        $fileSize = $this->getVideoDetails->getVideoFileSize("http://127.0.0.1/Error");
        $this->assertEquals($fileSize, 0);
    }
}
