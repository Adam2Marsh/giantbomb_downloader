<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\RulesRepository;

class RulesRepositoryTest extends TestCase
{

    protected $rulesRepository;

  	public function setup()
  	{
  		$this->rulesRepository = new \App\Repositories\RulesRepository;
      parent::setup();
  	}

    /**
     * Test Rule Matching
     *
     * @return void
     */
    public function testVideoMatchRules()
    {
      var_dump($this->rulesRepository->VideoMatchRules("Quick Look: Backtrack Redux"));
    }
}
