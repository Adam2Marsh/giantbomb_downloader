<?php

use App\Repositories\VideoRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoRepositoryTest extends TestCase
{

    use DatabaseMigrations;

	protected $videoRepository;

	public function setup()
	{
		$this->videoRepository = new VideoRepository;
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
        $localVideo->publish_date = date('Y-m-d H:i:s');

		$localVideo->image = new \stdClass();
		$localVideo->image->small_url = "http://thumburl.co.uk";

        $this->videoRepository->addVideoToDatabase($localVideo, "http://thumburl.co.uk");
        $this->assertTrue($this->videoRepository->CheckIfVideoIsInDatabase($localVideo->name));
        // $deletedRow = App\Video::where('gb_Id', $localVideo->id)->delete();
    }

    /**
    * Checking if video is in database sucessful
    * @return void
    */
    public function test_checkVideoDoesExist_Success()
    {
        $this->assertTrue($this->videoRepository->CheckIfVideoIsInDatabase('123 Testing 321'));
    }

    /**
    * Checking if video is in database sucessful
    * @return void
    */
    public function test_updateVideoToDownloadedStatus_Success()
    {
        $video = App\Video::where('gb_Id', 12345)->first();
        $this->videoRepository->updateVideoToDownloadedStatus($video->id, "DOWNLOADED");

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
        $videoName = $this->videoRepository->deleteVideoFromDatabase($video->id);
        $this->assertEquals($videoName,"123 Testing 321");
    }

    /**
    * Checking that video doesn't exist in database
    * @return void
    */
    public function test_checkVideoDoesExist_Fail()
    {
        $this->assertFalse($this->videoRepository->CheckIfVideoIsInDatabase('123 Testing 321'));
    }

    /**
     * Check that a high url is returned when HD is null
     */
    public function test_findHighestQualityVideo_Success_HighURL()
    {
        $video = new \stdClass();
        $video->hd_url = null;
        $video->high_url = "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_3200.mp4";
        $video->low_url = "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_1800.mp4";

        $this->assertEquals(
            "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_3200.mp4",
            $this->videoRepository->findHighestQualityVideo($video));
    }

    /**
     * Check that a hd url
     */
    public function test_findHighestQualityVideo_Success_HDURL()
    {
        $video = new \stdClass();
        $video->hd_url = "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_3200.mp4";
        $video->high_url = "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_3200.mp4";
        $video->low_url = "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_1800.mp4";

        $this->assertEquals(
            "https://giantbomb-pdl.akamaized.net/2017/03/10/vf_shadowtactics_ql_030917_3200.mp4",
            $this->videoRepository->findHighestQualityVideo($video));
    }

    /**
     * Make sure the filename returned will work on a filesystem
     */
    public function test_covertTitleToFileName_Success()
    {
        $this->assertEquals(
            "quick_look_shadow_tactics_bladesofthe_shogun.mp4",
            $this->videoRepository->covertTitleToFileName("Quick Look: Shadow Tactics: Blades of the Shogun"));
    }
}
