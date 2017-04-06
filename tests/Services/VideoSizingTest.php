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

        $this->videoStorage->downloadVideofromURL(
            "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4"
            ,"gb_videos"
            ,"video_size_test.mp4");
    }

    /**
     * Checks we can find a video and return its size as raw bytes
     *
     * @return void
     */
    public function test_GetVideoSizeAsBytes()
    {
        $this->assertEquals("1630631", $this->videoSizing
                    ->getVideoSize("test/Frontend_Vid_YouTube.mov")
                    ->returnAsBytes());
    }

    /**
     * Checks we can find a video and return its size in human format
     *
     * @return void
     */
    public function test_GetVideoSizeAsHuman()
    {
        $this->assertEquals("1.56MB", $this->videoSizing
                    ->getVideoSize("test/Frontend_Vid_YouTube.mov")
                    ->returnAsHuman());
    }

    /**
     * Checks we can find a video and return its size as as percentage
     *
     * @return void
     */
    public function test_GetVideoSizeAsPercentage()
    {
        $this->assertEquals("91%", $this->videoSizing
                    ->getVideoSize("test/Frontend_Vid_YouTube.mov")
                    ->returnAsPercentage(1800631));
    }

    /**
     * Checks we can find a directory and return its size as raw bytes
     *
     * @return void
     */
    public function test_GetDirectorySizeAsBytes()
    {
        $this->assertEquals("4891893", $this->videoSizing
                    ->getDirectorySize("test")
                    ->returnAsBytes());
    }

    /**
     * Checks we can find a directory and return its size in human format
     *
     * @return void
     */
    public function test_GetDirectorySizeAsHuman()
    {
        $this->assertEquals("4.67MB", $this->videoSizing
                    ->getDirectorySize("test")
                    ->returnAsHuman());
    }

    /**
     * Checks we can find a directory and return its size as as percentage
     *
     * @return void
     */
    public function test_GetDirectorySizeAsPercentage()
    {
        $this->assertEquals("56%", $this->videoSizing
                    ->getDirectorySize("test")
                    ->returnAsPercentage(8800631));
    }

}
