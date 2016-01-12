<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoStatusRepoTest extends TestCase
{

	protected $vsr;

	public function setup()
	{
		$this->vsr = new \App\Repositories\VideoStatusRepo;
	}

    /**
    * Test adding and checking for video is in database
    * @return void
    */
    public function test_AddVideoToDatabase()
    {
        $localVideoDetails = new \stdClass();
        $localVideoDetails -> hd_url = 'http://123/testing.co.uk';
        $localVideoDetails -> id = 12345;
        $localVideoDetails -> name = '123 Testing 321';
        $localVideoDetails -> publish_date = '2015-12-18 20:00:00';

        $this->vsr->AddVideoToDatabase($localVideoDetails);
        $this->assertTrue($this->vsr->CheckIfVideoIsInDatabase($localVideoDetails));
        $deletedRow = App\VideoStatus::where('gb_Id', $localVideoDetails->id)->delete();
    }

    /**
    * Checking if video is in database
    * @return void
    */
    public function test_CheckVideoDoesntExist()
    {
        $localVideoDetails = new \stdClass();
        $localVideoDetails -> hd_url = 'http://123/testing.co.uk';
        $localVideoDetails -> id = 12345;
        $localVideoDetails -> name = '123 Testing 321';
        $localVideoDetails -> publish_date = '2015-12-18 20:00:00';
        
        $this->assertFalse($this->vsr->CheckIfVideoIsInDatabase($localVideoDetails));
    }

}
