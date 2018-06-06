<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Rule;

class RuleApiTest extends TestCase
{
    /**
     * Test rules are returned via api
     *
     * @return void
     */
    public function test_rule_api_all()
    {
        $response = $this->json('GET', '/api/rules/all');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rule' => "RuleApiTest"
        ]);
    }

    /**
     * Test we can add a rule via the api
     *
     * @return void
     */
    public function test_rule_api_add()
    {
        $response = $this->json(
            'POST',
            '/api/rule/add',
            [
                'rule' => 'TestApiAdd'
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rule' => "TestApiAdd"
        ]);
    }

    /**
     * Test we can add a rule via the api
     *
     * @return void
     */
    public function test_rule_api_update()
    {
        $ruleId = Rule::where('rule', '=', 'TestApiAdd')->first()->id;

        $response = $this->json(
            'POST',
            "/api/rule/$ruleId/update",
            [
                'enabled' => 'false'
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'enabled' => 0
        ]);
    }

    /**
     * Test we can delete a rule via the api
     *
     * @return void
     */
    public function test_rule_api_delete()
    {
        $ruleId = Rule::where('rule', '=', 'TestApiAdd')->first()->id;

        $response = $this->json(
            'POST',
            "/api/rule/$ruleId/delete",
            [
                'enabled' => 'false'
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'deleted'
        ]);
    }
}
