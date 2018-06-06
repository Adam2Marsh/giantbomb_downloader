<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsApiTest extends TestCase
{
    /**
     * Test settings are returned via api
     *
     * @return void
     */
    public function test_settings_api_all()
    {
        $response = $this->json('GET', '/api/settings');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'key' => "storage_limit"
        ]);
    }

    /**
     * Test we can update a setting via the api
     *
     * @return void
     */
    public function test_settings_api_update()
    {
        $response = $this->json(
            'POST',
            '/api/settings',
            [
                'key' => "storage_limit",
                'value' => "20000000000"
            ]
        );

        $response->assertStatus(302);
    }
}
