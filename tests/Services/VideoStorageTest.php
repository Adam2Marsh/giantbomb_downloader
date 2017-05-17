<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\VideoStorage;
use App\Video;

class VideoStorageTest extends TestCase
{

    use DatabaseTransactions;

	protected $videoStorage;

	public function setup()
	{
		$this->videoStorage = new VideoStorage;
        parent::setUp();
	}

    /**
     * Test downloading a video
     */
    public function test_DownloadVideoFromURL()
    {
        $testVid = "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4";
        $this->videoStorage->downloadVideofromURL($testVid, "gb_videos", "TestVideo.mp4");
    }

    /**
     * Test downloading a video which doesn't exist, should fail
     * @expectedException Exception
     */
    public function test_saveVideo_Fail()
    {
        $newVideo = new Video;
        $newVideo->name = "Fail Video as bad url";
        $newVideo->file_name = "FailVideo.mp4";
        $newVideo->url = "localhost/ft_060311_3500.mp4";
        $newVideo->save();

        $this->videoStorage->saveVideo($newVideo);
    }

     /**
     * Check for downloaded video
     */
    public function test_checkForVideo_Success()
    {
        $this->assertTrue($this->videoStorage->checkForVideo("gb_videos/TestVideo.mp4"));
    }

     /**
     * Check for video not downloaded
     *
     * @return void
     */
    public function test_checkForVideo_Failure()
    {
		$this->assertFalse($this->videoStorage->checkForVideo("gb_videos/Unknown.mp4"));
    }
    
     /**
     * Delete video downloaded for testing
     *
     * @return void
     */
    public function test_deleteVideo_Success()
    {
    	$this->videoStorage->deleteVideo("gb_videos/TestVideo.mp4");
		$this->assertFalse($this->videoStorage->checkForVideo("gb_videos/TestVideo.mp4"));
    }

}
