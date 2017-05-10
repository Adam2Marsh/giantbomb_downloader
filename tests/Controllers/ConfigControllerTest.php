<?php

use App\Repositories\ConfigRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Config;

class ConfigControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * For tests to run we need API Key present so Middleware so kick it out
     */
    public function setUp()
    {
        parent::setUp();
        $configRepo = new ConfigRepository();
        $configRepo->UpdateConfig("API_KEY", "TEST");
    }

    /**
     * Check main Rules GUI
     *
     * @return void
     */
    public function testGuiMainPage()
    {
        $this->visit('/configs')
            ->see('Giantbomb Account Linked');
    }

    /**
     * Add Slack Url Successfully
     *
     * @return void
     */
    public function testAddSlackHookUrl()
    {
        $this->visit('/configs')
            ->type('https://hooks.slack.com/services/T','value')
            ->press('Submit')
            ->seePageIs('/configs')
            ->see('Config Added Successfully');
    }

    /**
     * Update Slack Url Successfully
     *
     * @return void
     */
    public function testUpdateSlackHookUrl()
    {
        $this->visit('/configs')
            ->type('https://hooks.slack.com/services/T','SLACK_HOOK_URL')
            ->press('Update')
            ->seePageIs('/configs')
            ->see('Config Updated Successfully');
    }

    /**
     * Update Slack Url UnSuccessfully
     *
     * @return void
     */
    public function testUpdateSlackHookUrl_Error()
    {
        $this->visit('/configs')
            ->type('INVALID','SLACK_HOOK_URL')
            ->press('Update')
            ->seePageIs('/configs')
            ->see('Slack Hook url doesn\'t look right, please make sure you copied everything');
    }

    /**
     * Delete Api Key
     *
     * @return void
     */
    public function testDeleteApiKey()
    {
        $this->visit('/configs')
            ->press('Delete')
            ->seePageIs('/FirstTime')
            ->see('Welcome to the Giantbomb Pi Downloader');
    }

}
