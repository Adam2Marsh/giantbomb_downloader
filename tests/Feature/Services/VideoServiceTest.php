<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\VideoService;
use App\Video;

class VideoServiceTest extends TestCase
{

    protected $videoService;

    protected function setUp()
    {
        parent::setUp();

        $this->videoService = new VideoService("Giantbomb");
    }

    /**
     * Test we can download the thumbnail of a video via it's url
     *
     * @return void
     */
    public function test_downloadThumbnail()
    {
        $testVideo = Video::findOrFail(1);

        $this->assertEquals(
            "storage/thumbnails/TestThumbnail",
            $this->videoService->downloadThumbnail(
                $testVideo,
                "TestThumbnail"
            )
        );
    }

    /**
     * Test we can download the video
     *
     * @return void
     */
    public function test_downloadVideo()
    {

        $this->markTestIncomplete('Needs doing!');
//        $this->assertEquals(
//            "http://giantbomb_downloader.test/storage/thumbnails/TestThumbnail",
//            $this->videoService->downloadThumbnail(
//                "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4",
//                "TestDownload"
//            )
//        );
    }

    /**
     * Test we can fetch the sie of a video via it's url
     *
     * @return void
     */
    public function test_getVideoFileSize()
    {
        $this->assertRegExp(
            '/\d+/',
            $this->videoService->getVideoFileSize(
                "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4"
            )
        );
    }
}
