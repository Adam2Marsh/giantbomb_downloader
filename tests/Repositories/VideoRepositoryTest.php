<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoRepositoryTest extends TestCase
{

	protected $vsr;

	public function setup()
	{
		$this->vsr = new \App\Repositories\VideoRepository;
	}

    /**
    * Test adding and checking for video is in database
    * @return void
    */
    public function test_removeSpecialCharactersFromString_Success()
    {
        $newString = $this->vsr->removeSpecialCharactersFromString("Te/s t:");
        $this->assertEquals("Te-s_t", $newString);
    }

    /**
    * Test adding and checking for video is in database
    * @return void
    */
    public function test_addVideoToDatabase_Success()
    {
        $localVideo = new \stdClass();
        $localVideo->hd_url = 'http://123/testing.co.uk';
        $localVideo->id = 12345;
        $localVideo->name = '123 Testing 321';
        $localVideo->publish_date = '2015-12-18 20:00:00';

				$localVideo->image = new \stdClass();
				$localVideo->image->small_url = "http://thumburl.co.uk";

        $localDetails = 123456;

        $this->vsr->addVideoToDatabase($localVideo, $localDetails);
        $this->assertTrue($this->vsr->CheckIfVideoIsInDatabase($localVideo->name));
        // $deletedRow = App\Video::where('gb_Id', $localVideo->id)->delete();
    }

    /**
    * Checking if video is in database sucessful
    * @return void
    */
    public function test_checkVideoDoesExist_Success()
    {
        $this->assertTrue($this->vsr->CheckIfVideoIsInDatabase('123 Testing 321'));
    }

    /**
    * Checking if video is in database sucessful
    * @return void
    */
    public function test_updateVideoToDownloadedStatus_Success()
    {
        $video = App\Video::where('gb_Id', 12345)->first();
        $this->vsr->updateVideoToDownloadedStatus($video->id, "DOWNLOADED");

        $video = App\Video::where('gb_Id', 12345)->first();
        $this->assertEquals($video->status, "DOWNLOADED");
    }


    /**
    * Will try and remove video from database
    * @return void
    */
    public function test_deleteVideoFromDatabase_Success()
    {
        $video = App\Video::where('gb_Id', 12345)->first();
        $videoName = $this->vsr->deleteVideoFromDatabase($video->id);
        $this->assertEquals($videoName,"123 Testing 321");
    }

    /**
    * Checking that video doesn't exist in database
    * @return void
    */
    public function test_checkVideoDoesExist_Fail()
    {
        $this->assertFalse($this->vsr->CheckIfVideoIsInDatabase('123 Testing 321'));
    }

}
