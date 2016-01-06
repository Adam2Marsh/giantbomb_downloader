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


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_GetJSON_Success()
    {

    	$ResponseJSON = $this->DVI->GetJSON('http://localhost/GB_Example_One.json');
        echo print_r($ResponseJSON, true);
    }



}
