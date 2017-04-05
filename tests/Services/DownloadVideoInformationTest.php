<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\DownloadVideoInformation;
use App\Rule;

class DownloadVideoInformationTest extends TestCase
{
	protected $downloadVideoInformation;

	public function setup()
	{
		$this->downloadVideoInformation = new DownloadVideoInformation;
        parent::setUp();
	}

    //Intergration Tests.......................
    public function test_updateVideosInDatabase_AddVideo()
    {
        $deletedRow = App\Video::where('gb_Id', '11408')->delete();
        $response = $this->downloadVideoInformation->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');
        $this->assertRegexp('/doesn\'t exists/i',strval($response));
    }

    public function test_updateVideosInDatabase_RuleTriggersDownload()
    {
        $rule = new Rule();
        $rule->regex = "Demo Derby";
        $rule->enabled = 1;
        $rule->save();

        $response = $this->downloadVideoInformation->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');

        $this->expectsJobs(App\Jobs\DownloadVideoJob::class);

        App\Video::where('gb_Id', '11408')->delete();
        $rule->delete();
    }

    public function test_updateVideosInDatabase_VideoAlreadyExists()
    {
        $deletedRow = App\Video::where('gb_Id', '11408')->delete();
        $addResponse = $this->downloadVideoInformation->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');
        $dupResponse = $this->downloadVideoInformation->updateVideosInDatabase('http://127.0.0.1/Test_Json','','');
        $this->assertRegexp('/already exists/i',strval($dupResponse));
        $deletedRow = App\Video::where('gb_Id', '11409')->delete();
    }

    public function test_getVideoFileSize()
    {
        $fileSize = $this->downloadVideoInformation->getVideoFileSize(env('TEST_VIDEO_URL',""));
        $this->assertRegexp('/\d+/', $fileSize);
    }

    public function test_getVideoFileSize_404Response()
    {
        $fileSize = $this->downloadVideoInformation->getVideoFileSize("http://127.0.0.1/Error");
        $this->assertEquals($fileSize, 0);
    }

}
