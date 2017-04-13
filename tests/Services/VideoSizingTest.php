<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\VideoSizing;
use App\Services\VideoStorage;

class VideoSizingTest extends TestCase
{

    //Sets up the variable we'll use to store the class
    private $videoSizing;

    private $videoStorage;

    //Here we will call the class ready for the test
    function setUp() {

        parent::setUp();

        $this->videoSizing = new VideoSizing();
        $this->videoStorage = new VideoStorage();

        if(!$this->videoStorage->checkForVideo("gb_videos", "video_size_test.mp4")) {
            $this->videoStorage->downloadVideofromURL(
                "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4"
                , "gb_videos"
                , "video_size_test.mp4");
        }
    }

    /**
     * Checks we can find a video and return its size as raw bytes
     *
     * @return void
     */
    public function test_GetVideoSizeAsBytes()
    {
        $this->assertEquals("11209849", $this->videoSizing
                    ->getVideoSize("gb_videos/video_size_test.mp4")
                    ->returnAsBytes());
    }

    /**
     * Checks we can find a video and return its size in human format
     *
     * @return void
     */
    public function test_GetVideoSizeAsHuman()
    {
        $this->assertEquals("10.69MB", $this->videoSizing
                    ->getVideoSize("gb_videos/video_size_test.mp4")
                    ->returnAsHuman());
    }

    /**
     * Checks we can find a video and return its size as as percentage
     *
     * @return void
     */
    public function test_GetVideoSizeAsPercentage()
    {
        $this->assertEquals("623%", $this->videoSizing
                    ->getVideoSize("gb_videos/video_size_test.mp4")
                    ->returnAsPercentage(1800631));
    }

    /**
     * Checks we can find a directory and return its size as raw bytes
     *
     * @return void
     */
    public function test_GetDirectorySizeAsBytes()
    {
        $this->assertEquals("11209849", $this->videoSizing
                    ->getDirectorySize("gb_videos")
                    ->returnAsBytes());
    }

    /**
     * Checks we can find a directory and return its size in human format
     *
     * @return void
     */
    public function test_GetDirectorySizeAsHuman()
    {
        $this->assertEquals("10.81MB", $this->videoSizing
                    ->getDirectorySize("gb_videos")
                    ->returnAsHuman());
    }

    /**
     * Checks we can find a directory and return its size as as percentage
     *
     * @return void
     */
    public function test_GetDirectorySizeAsPercentage()
    {
        $this->assertEquals("127%", $this->videoSizing
                    ->getDirectorySize("gb_videos")
                    ->returnAsPercentage(8800631));
    }

}
