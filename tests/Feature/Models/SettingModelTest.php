<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Setting;

class SettingModelTest extends TestCase
{

    protected $setting;

    protected function setUp()
    {
        parent::setUp();

        $this->setting = Setting::findOrFail(1);
    }

    /**
     * Test Nice Format comes back okay
     *
     * @return void
     */
    public function test_getNiceFormatAttribute()
    {
        $this->assertEquals(
            "Storage Limit",
            $this->setting->nice_format
        );
    }
}
