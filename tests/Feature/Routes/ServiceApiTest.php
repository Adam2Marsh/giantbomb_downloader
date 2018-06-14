<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

use App\Service;

class ServiceApiTest extends TestCase
{
    /**
     * Test services are returned via api
     *
     * @return void
     */
    public function test_services_api_all()
    {
        $response = $this->json('GET', '/api/services');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => "VideoServicesRepositoryTest"
        ]);
    }

    /**
     * Test we can update a service via the api
     *
     * @return void
     */
    public function test_service_api_update()
    {
        $ruleId = Service::where('name', '=', 'VideoServicesRepositoryTest')->first()->id;

        $response = $this->json(
            'POST',
            "/api/service/$ruleId/update",
            [
                'enabled' => 'true'
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'enabled' => 1
        ]);
    }

    /**
     * Test we can fetch new services
     *
     * @return void
     */
    public function test_services_api_fetch_videos()
    {
        $ruleId = Service::where('name', '=', 'VideoServicesRepositoryTest')->first()->id;

        $response = $this->json(
            'POST',
            "/api/service/$ruleId/update",
            [
                'enabled' => 'false'
            ]
        );

        Event::fake();

        $response = $this->json('GET', '/api/services/fetch');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            "Video Services Refreshed"
        ]);
    }

    /**
     * Test we can register for a service
     *
     * @return void
     */
    public function test_service_api_register()
    {
        $this->markTestIncomplete('Needs doing!');
    }
}
