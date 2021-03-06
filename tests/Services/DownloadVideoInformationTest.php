<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\DownloadVideoInformation;
use App\Rule;

class DownloadVideoInformationTest extends TestCase
{
    use DatabaseTransactions;

	protected $downloadVideoInformation;

	public function setup()
	{
		$this->downloadVideoInformation = new DownloadVideoInformation;
        parent::setUp();
	}

    //Integration Tests.......................
    public function test_updateVideosInDatabase_AddVideo()
    {
        $response = $this->grabVideos();
        $this->assertRegexp('/doesn\'t exists/i',strval($response));
    }

    public function test_updateVideosInDatabase_RuleTriggersDownload()
    {
        $this->expectsJobs(App\Jobs\DownloadVideoJob::class);

        $rule = new Rule();
        $rule->regex = "Snake Pass";
        $rule->enabled = 1;
        $rule->save();

        $response = $this->grabVideos();
        $rule->delete();
    }

    public function test_updateVideosInDatabase_VideoAlreadyExists()
    {
        $addResponse = $this->grabVideos();
        $dupResponse = $this->grabVideos();
        $this->assertRegexp('/already exists/i',strval($dupResponse));
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

    public function grabVideos()
    {
        return $this->downloadVideoInformation->updateVideosInDatabase(
            config('gb.api_address'),
            config('gb.api_query'),
            config('')
        );
    }

}
