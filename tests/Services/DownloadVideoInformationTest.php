<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DownloadVideoInformationTest extends TestCase
{

	protected $dvi;

	public function setup()
	{
		$this->dvi = new \App\Services\DownloadVideoInformation;
	}

    //Unit Tests...............................

    /**
    * Check on 200 function returns true
    * @return void
    */
    public function test_checkHTTPCallSucessful()
    {
        $this->assertTrue($this->dvi->checkHTTPCallSucessful(200));
    }


    //Intergration Tests.......................

    /**
    * Test getting JSON via localhost
    * @return void
    */
    public function test_getJSON_Success()
    {
    	$responseJSON = $this->dvi->getJSON(env('TEST_JSON_URL',config('gb.Website_Address')));
        $this->assertEquals($responseJSON->results[0]->id,10924);
    }

}
