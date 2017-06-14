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
        $this->expectsJobs(App\Jobs\GetVideoThumbnailJob::class);
        $this->expectsJobs(App\Jobs\GetVideoFilesizeJob::class);

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

    public function grabVideos()
    {
        return $this->downloadVideoInformation->updateVideosInDatabase(
            config('gb.api_address'),
            config('gb.api_query'),
            config('')
        );
    }

}
