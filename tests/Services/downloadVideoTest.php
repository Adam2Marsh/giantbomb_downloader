<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class downloadVideoTest extends TestCase
{


	protected $dv;

	public function setup() 
	{
		$this->dv = new \App\Services\downloadVideo;;
	}

    /**
     * Test downloading a video
     *
     * @return void
     */
    public function test_DownloadVideoFromURL()
    {
        $testVid = "http://homestead.app/TestVideo";
        $this->dv->downloadVideofromURL($testVid, "test", "TestVideo.mp4");
    }

     /**
     * Check for downloaded video
     *
     * @return void
     */
    public function test_checkForDownloadedVideo_Success()
    {
        $this->assertTrue($this->dv->checkForDownloadedVideo("test","TestVideo.mp4"));
    }

     /**
     * Check for video not downloaded
     *
     * @return void
     */
    public function test_checkForDownloadedVideo_Failure()
    {
		$this->assertFalse($this->dv->checkForDownloadedVideo("test","WontBeFound.mp4"));
    }
}
