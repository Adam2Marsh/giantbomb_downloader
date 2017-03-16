<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Rule;

class RuleControllerTest extends TestCase
{
    /**
     * Check main Rules GUI
     *
     * @return void
     */
    public function testGuiMainPage()
    {
      $this->visit('/rules')
           ->see('Create new Rules Here');
    }

    /**
     * Create new Rule
     *
     * @return void
     */
    public function testDuplicateRuleError()
    {
      $this->visit('/rules')
           ->type('Just a Test','regex')
           ->check('enabled')
           ->press('Save')
           ->seePageIs('/rules')
           ->see('Rule Added Successfully');
    }

    /**
     * Create new Rule
     *
     * @return void
     */
    public function testAddNewRule()
    {
      $this->visit('/rules')
           ->type('Just a Test','regex')
           ->check('enabled')
           ->press('Save')
           ->seePageIs('/rules')
           ->see('Rule Already Exists');
    }

    /**
     * Update Rule
     *
     * @return void
     */
    public function testUpdateRule()
    {
      $rule = Rule::where('regex', '=', 'Just a Test')->first();

      $this->json('PUT', "/rules/$rule->id", ['enabled' => 0, '_token' => csrf_token()])
        ->seeJsonEquals([
          'status' => 0,
        ]);
    }

    /**
     * Create new Rule
     *
     * @return void
     */
    public function testDeleteRule()
    {

      $rule = Rule::where('regex', '=', 'Just a Test')->first();

      $this->visit('/rules')
           ->press($rule->id . "DELETE")
           ->seePageIs('/rules')
           ->see('Rule Deleted Successfully');
    }
}
