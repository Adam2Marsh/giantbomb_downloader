<?php

namespace Tests\Feature;

use App\Repositories\VideoServicesRepository;
use App\Service;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoServicesRepositoryTest extends TestCase
{
    protected $videoServiceRepo;

    protected function setUp()
    {
        parent::setUp();

        $this->videoServiceRepo = new VideoServicesRepository("VideoServicesRepositoryTest");
    }

    /**
     * Test we can toggle a service
     *
     * @return void
     */
    public function test_toggleService()
    {
        $this->videoServiceRepo->toggleService(1);

        $this->assertEquals(
            1,
            Service::where('name', '=', 'VideoServicesRepositoryTest')->first()->enabled
        );
    }
}
