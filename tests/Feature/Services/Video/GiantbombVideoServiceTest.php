<?php

namespace Tests\Feature;

use App\Setting;
use Tests\TestCase;
use App\Services\Video\GiantbombVideoService;

class GiantbombVideoServiceTest extends TestCase
{

    protected $giantbombVideoService;

    protected $videoServiceConfigurationRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->giantbombVideoService = new GiantbombVideoService();

        $newSetting = new Setting();
        $newSetting->service_id = 1;
        $newSetting->key = "api_key";
        $newSetting->value = ENV('GB_API_KEY', '');
        $newSetting->save();
    }


    /**
     * Check we can get a list of the latest videos from the API
     *
     * @return void
     */
    public function test_fetchLatestVideosFromApi()
    {
        $response = $this->giantbombVideoService->fetchLatestVideosFromApi();

        $this->assertRegExp('/\d+ videos were added for Giantbomb/', $response);
    }
}
