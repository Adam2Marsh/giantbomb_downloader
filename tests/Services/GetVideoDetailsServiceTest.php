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
        echo $this->getVideoDetails->downloadVideoThumbnail(
            "//static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg"
        );
    }

}
