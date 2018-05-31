<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;

use App\Video;

class VideoModelTest extends TestCase
{

    protected $testVideo;

    protected function setUp()
    {
        parent::setUp();

        $this->testVideo = Video::findOrFail(1);
    }

    /**
     * Test human size comes back as expected
     *
     * @return void
     */
    public function test_getHumanSizeAttribute()
    {
        $this->artisan("db:seed");

        $this->assertEquals(
            "10.81MB",
            $this->testVideo->human_size
        );
    }


    /**
     * Test downloaded percentage comes back as expected
     *
     * @return void
     */
    public function test_getDownloadedPercentageAttribute()
    {
        $this->artisan("db:seed");

        $this->assertEquals(
            "0%",
            $this->testVideo->downloaded_percentage
        );
    }
}
