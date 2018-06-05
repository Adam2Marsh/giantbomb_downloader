<?php

namespace Tests\Feature;

use App\Repositories\VideoServiceConfigurationRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoServiceConfigurationRepositoryTest extends TestCase
{

    protected $videoServiceConfigRepo;

    protected function setUp()
    {
        parent::setUp();

        $this->videoServiceConfigRepo = new VideoServiceConfigurationRepository();
    }

    /**
     * Test we can add an API key to DB
     *
     * @return void
     */
    public function test_storeServiceApiKey()
    {
        $api_key = uniqid();

        $this->videoServiceConfigRepo->storeServiceApiKey(
            2,
            $api_key
        );

        $this->assertEquals(
            $api_key,
            $this->videoServiceConfigRepo->getServiceApiKey(2)
        );
    }
}
