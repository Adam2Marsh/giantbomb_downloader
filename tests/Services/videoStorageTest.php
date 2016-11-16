<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoStorageTest extends TestCase
{

	protected $dv;

	public function setup()
	{
		$this->dv = new \App\Services\VideoStorage;
        parent::setUp();
	}

    /**
     * Test downloading a video
     */
    public function test_DownloadVideoFromURL()
    {
        $testVid = "http://homestead.app/TestVideo";
        $this->dv->downloadVideofromURL($testVid, "test", "TestVideo.mp4");
    }

     /**
     * Check for downloaded video
     */
    public function test_checkForVideo_Success()
    {
        $this->assertTrue($this->dv->checkForVideo("test","TestVideo.mp4"));
    }

     /**
     * Check for video not downloaded
     *
     * @return void
     */
    public function test_checkForVideo_Failure()
    {
		$this->assertFalse($this->dv->checkForVideo("test","WontBeFound.mp4"));
    }
    
     /**
     * Delete video downloaded for testing
     *
     * @return void
     */
    public function test_deleteVideo_Success()
    {
    	$this->dv->deleteVideo("test","TestVideo.mp4");
		$this->assertFalse($this->dv->checkForVideo("test","TestVideo.mp4"));
    }

}
