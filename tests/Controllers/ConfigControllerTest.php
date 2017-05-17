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
            ->type('https://hooks.slack.com/services/T','SLACK_HOOK_URLvalue')
            ->press('Update Slack')
            ->seePageIs('/configs')
            ->see('Config Added Successfully');
    }

    /**
     * Add Slack Url Successfully
     *
     * @return void
     */
    public function testRemoveSlackHookUrl()
    {
        $this->visit('/configs')
            ->type('','SLACK_HOOK_URLvalue')
            ->press('Update Slack')
            ->seePageIs('/configs')
            ->see('Config Added Successfully');
    }

    /**
     * Update Slack Url UnSuccessfully
     *
     * @return void
     */
    public function testUpdateSlackHookUrl_Error()
    {
        $this->visit('/configs')
            ->type('INVALID','SLACK_HOOK_URLvalue')
            ->press('Update Slack')
            ->seePageIs('/configs')
            ->see('Slack Hook url doesn\'t look right, please make sure you copied everything');
    }

    /**
     * Remove Storage Path Successfully
     *
     * @return void
     */
    public function testAddStorageDirectory()
    {
        $this->visit('/configs')
            ->type('/mnt','STORAGE_LOCATIONvalue')
            ->press('Update Storage Location')
            ->seePageIs('/configs')
            ->see('Config Added Successfully');
    }

    /**
     * Remove Storage Path Successfully
     *
     * @return void
     */
    public function testRemoveStorageDirectory()
    {
        $this->visit('/configs')
            ->type('','STORAGE_LOCATIONvalue')
            ->press('Update Storage Location')
            ->seePageIs('/configs')
            ->see('Config Added Successfully');
    }

    /**
     * Update Slack Url UnSuccessfully
     *
     * @return void
     */
    public function testAddStorageDirectory_Error()
    {
        $this->visit('/configs')
            ->type('INVALID','STORAGE_LOCATIONvalue')
            ->press('Update Storage Location')
            ->seePageIs('/configs')
            ->see('You need to enter a directory which exists');
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
