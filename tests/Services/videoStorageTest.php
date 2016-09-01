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
     * Check Directory Size is human readable
     *
     * @return void
     */
    public function test_videoStorageHumanSize_Success()
    {
        $this->assertEquals("1.56MB", $this->dv->videoStorageHumanSize("test"));
    }

    /**
    * Check Directory Size is a raw number
    *
    * @return void
    */
   public function test_videoStorageRawSize_Success()
   {
       $this->assertEquals("1630631", $this->dv->videoStorageRawSize("test"));
   }

    /**
    * Check Directory Size is a percentage
    *
    * @return void
    */
   public function test_videoStoragePercentage_Success()
   {
       $this->assertEquals("0.0077754545211792%", $this->dv->videoStorageSizeAsPercentage("test"));
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
