<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DownloadVideoInformationTest extends TestCase
{

	protected $DVI;

	public function setup()
	{
		$this->DVI = new \App\Services\DownloadVideoInformation;
	}

    //Unit Tests...............................

    /**
    * Check on 200 function returns true
    * @return void
    */
    public function test_CheckHTTPCallSucessful()
    {
        $this->assertTrue($this->DVI->CheckHTTPCallSucessful(200));
    }


    //Intergration Tests.......................

    /**
    * Test getting JSON via localhost
    * @return void
    */
    public function test_GetJSON_Success()
    {
    	$ResponseJSON = $this->DVI->GetJSON(env('TEST_JSON_URL',config('gb.Website_Address')));
        $this->assertEquals($ResponseJSON->results[0]->id,10924);
    }

    /**
    * Test adding and checking for video is in database
    * @return void
    */
    public function test_AddVideoToDatabase()
    {
        $LocalVideoDetails = new \stdClass();
        $LocalVideoDetails -> hd_url = 'http://123/testing.co.uk';
        $LocalVideoDetails -> id = 12345;
        $LocalVideoDetails -> name = '123 Testing 321';
        $LocalVideoDetails -> publish_date = '2015-12-18 20:00:00';

        $this->DVI->AddVideoToDatabase($LocalVideoDetails);
        $this->assertTrue($this->DVI->CheckIfVideoIsInDatabase($LocalVideoDetails));
        $deletedRow = App\VideoStatus::where('gb_Id', $LocalVideoDetails->id)->delete();
    }

}
