<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\DiskService;

class DiskServiceTest extends TestCase
{

    protected $diskService;

    protected function setUp()
    {
        parent::setUp();

        $this->diskService = new DiskService("Giantbomb");
    }

    /**
     * Test disk space used is returned
     *
     * @return void
     */
    public function test_calculateDiskSpace()
    {
        $this->assertRegExp(
            '/\d+/',
            $this->diskService->calculateDiskSpace()
        );
    }

    /**
     * Test videos in a downloading status are returned with percentage
     *
     * @return void
     */
    public function test_videosDownloadingProgress()
    {
        $this->assertEquals(
            [
                [
                    'id' => 2,
                    'download_percentage' => '0%'
                ],
                [
                    'id' => 3,
                    'download_percentage' => '0%'
                ]
            ],
            $this->diskService->videosDownloadingProgress()
        );
    }
}