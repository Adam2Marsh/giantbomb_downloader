<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GiantBombApiServiceTest extends TestCase
{

    protected $giantBombApiService;

    public function setup()
    {
        $this->giantBombApiService = new \App\Services\GiantBombApiService();
        parent::setUp();
    }

    public function test_validateApiKey()
    {
        $apiKey = $this->giantBombApiService->getApiKey("3B56B5");
        $this->assertEquals($apiKey->api_key, "71db34446b406a050e61a23b28fdcdfbb22917f1");
    }

    public function test_checkApiKeyIsPremium()
    {
        echo $this->giantBombApiService->checkApiKeyIsPremium("71db34446b406a050e61a23b28fdcdfbb22917f1");

        // $this->assertEquals($apiKey->api_key, "71db34446b406a050e61a23b28fdcdfbb22917f1");
    }

}
