<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Rule;

class DownloadVideoInformationTest extends TestCase
{

	protected $dvi;

	public function setup()
	{
		$this->dvi = new \App\Services\DownloadVideoInformation;
        parent::setUp();
	}

    /**
    * Check on 200 function returns true
    * @return void
    */
    public function test_checkHTTPCallSucessful_TrueResponse()
    {
        $this->assertTrue($this->dvi->checkHTTPCallSucessful(200));
    }

    /**
    * Test getting JSON via localhost
    * @return void
    */
    public function test_getJSON_Success()
    {
    	$responseJSON = $this->dvi->getJSON(env('TEST_JSON_URL',config('gb.Website_Address')));
        $this->assertEquals($responseJSON->results[0]->id,11408);
    }

    //Intergration Tests.......................
    public function test_updateVideosInDatabase_AddVideo()
    {
        $deletedRow = App\Video::where('gb_Id', '11408')->delete();
        $response = $this->dvi->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');
        $this->assertRegexp('/doesn\'t exists/i',strval($response));
    }

    public function test_updateVideosInDatabase_RuleTriggersDownload()
    {
        $rule = new Rule();
        $rule->regex = "Demo Derby";
        $rule->enabled = 1;
        $rule->save();

        $response = $this->dvi->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');

        $this->expectsJobs(App\Jobs\DownloadVideoJob::class);

        App\Video::where('gb_Id', '11408')->delete();
        $rule->delete();
    }

    public function test_updateVideosInDatabase_VideoAlreadyExists()
    {
        $deletedRow = App\Video::where('gb_Id', '11408')->delete();
        $addResponse = $this->dvi->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');
        $dupResponse = $this->dvi->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');
        $this->assertRegexp('/already exists/i',strval($dupResponse));
    }

    public function test_getVideoFileSize()
    {
        $fileSize = $this->dvi->getVideoFileSize(env('TEST_VIDEO_URL',""));
        $this->assertRegexp("/\d+/", $fileSize);
    }

    public function test_getVideoFileSize_404Response()
    {
        $fileSize = $this->dvi->getVideoFileSize("http://127.0.0.1/Error");
        $this->assertEquals($fileSize, 0);
    }

}
