<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Config;

class ConfigRepositoryTest extends TestCase
{

    protected $configsRepository;

  	public function setup()
  	{
  	    $this->configsRepository = new \App\Repositories\ConfigRepository();
        parent::setup();
  	}

    public function test_AddNewConfig()
    {
        $this->configsRepository->UpdateConfig("TEST", "TEST");

        $config = Config::where('name', 'TEST')->first();
        $this->assertEquals("TEST", $config->value);
    }

    public function test_UpdateConfig()
    {
        $this->configsRepository->UpdateConfig("TEST", 12345);

        $config = Config::where('name', 'TEST')->first();
        $this->assertEquals("12345", $config->value);
    }

}
