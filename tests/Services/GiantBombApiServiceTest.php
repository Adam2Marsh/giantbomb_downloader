<?php

use App\Services\GiantBombApiService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GiantBombApiServiceTest extends TestCase
{

    protected $giantBombApiService;

    public function setup()
    {
        $this->giantBombApiService = new GiantBombApiService();
        parent::setUp();
    }

//    public function test_validateApiKey()
//    {
//        $apiKey = $this->giantBombApiService->getApiKey("3B56B5");
//        $this->assertEquals($apiKey->api_key, config('gb.api_key'));
//    }

//    public function test_checkApiKeyIsPremium()
//    {
//        echo $this->giantBombApiService->checkApiKeyIsPremium(config('gb.api_key'));
//    }

}
