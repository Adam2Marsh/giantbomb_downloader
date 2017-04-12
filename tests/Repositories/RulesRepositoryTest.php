<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\RulesRepository;

use App\Rule;

class RulesRepositoryTest extends TestCase
{

    use DatabaseMigrations;

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
    public function testVideoMatchRules_True()
    {

      $rule = new Rule();
      $rule->regex = "Quick Look";
      $rule->enabled = 1;
      $rule->save();

      $this->assertTrue($this->rulesRepository->VideoMatchRules("Quick Look: Backtrack Redux"));

      $rule->delete();
    }

    /**
     * Test Rule Matching
     *
     * @return void
     */
    public function testVideoMatchRules_False()
    {
      $this->assertFalse($this->rulesRepository->VideoMatchRules("Metal Gear Solid"));
    }
}
