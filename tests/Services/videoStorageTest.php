<?php

use App\Services\VideoStorage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoStorageTest extends TestCase
{

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
        $this->videoStorage->downloadVideofromURL($testVid, "test", "TestVideo.mp4");
    }

     /**
     * Check for downloaded video
     */
    public function test_checkForVideo_Success()
    {
        $this->assertTrue($this->videoStorage->checkForVideo("test","TestVideo.mp4"));
    }

     /**
     * Check for video not downloaded
     *
     * @return void
     */
    public function test_checkForVideo_Failure()
    {
		$this->assertFalse($this->videoStorage->checkForVideo("test","WontBeFound.mp4"));
    }
    
     /**
     * Delete video downloaded for testing
     *
     * @return void
     */
    public function test_deleteVideo_Success()
    {
    	$this->videoStorage->deleteVideo("test","TestVideo.mp4");
		$this->assertFalse($this->videoStorage->checkForVideo("test","TestVideo.mp4"));
    }

}
