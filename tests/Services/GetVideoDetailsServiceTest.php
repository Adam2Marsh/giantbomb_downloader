<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetVideoDetailsServiceTest extends TestCase
{

    protected $getVideoDetails;

    public function setup()
    {
        $this->getVideoDetails = new \App\Services\GetVideoDetailsService;
        parent::setUp();
    }

    public function test_downloadVideoThumbnail()
    {
        $path = $this->getVideoDetails->downloadVideoThumbnail(
            "http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg"
            , "JustTesting"
        );

        echo $path;

        // $this->assertEquals("/home/vagrant/giantbomb-downloader/public/JustTesting.png", $path);
    }

}
