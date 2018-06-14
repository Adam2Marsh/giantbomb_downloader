<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

use App\Video;
use Storage;

class VideosApiTest extends TestCase
{
    /**
     * Check videos are returned from all api
     *
     * @return void
     */
    public function test_video_api_all()
    {
        $response = $this->json('GET', '/api/videos/all');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => "VideoModelTest"
        ]);
    }

    /**
     * Check Disk Space
     *
     * @return void
     */
    public function test_video_api_disk_space()
    {
        Event::fake();

        $response = $this->json('GET', '/api/videos/space');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            "Disk Space Job Triggered"
        ]);
    }

    /**
     * Test we can update a video status
     *
     * @return void
     */
    public function test_video_api_update()
    {
        Event::fake();

        $ruleId = Video::where('name', '=', 'VideoModelTest')->first()->id;

        $response = $this->json(
            'POST',
            "/api/video/$ruleId/updateStatus",
            [
                'state' => 'watched'
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'newState' => "watched"
        ]);
    }

    /**
     * Test we can download a video
     *
     * @return void
     */
    public function test_video_api_download()
    {
        Event::fake();

        Storage::put('videos/Giantbomb/video_model_test.mp4', 'LocalTestFile');

        $ruleId = Video::where('name', '=', 'VideoModelTest')->first()->id;

        $response = $this->json(
            'GET',
            "/api/video/$ruleId/download"
        );

        $response->assertStatus(200);
    }
}
