<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\StorageService;
use App\Repositories\ConfigRepository;

class StorageRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    protected $configRepo;

    function __construct()
    {
        $this->configRepo = new ConfigRepository();
        parent::setUp();
    }

    public function test_returnDiskName_local()
    {
        $storageRepo = new StorageService();

        $this->assertEquals("local", $storageRepo->returnDiskName());
    }

    public function test_returnPath_local()
    {
        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '');

        $storageRepo = new StorageService();

        $this->assertContains("giantbomb-downloader/storage/app/", $storageRepo->returnPath());
    }


    public function test_returnDiskName_root()
    {
        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '/mnt/external/test');

        $storageRepo = new StorageService();

        $this->assertEquals("root", $storageRepo->returnDiskName());
    }

    public function test_returnPath_root()
    {
        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '/mnt/external/test');

        $storageRepo = new StorageService();

        $this->assertEquals("//mnt/external/test/", $storageRepo->returnPath());

        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '');
    }

    public function test_spaceLeftOnDiskAfterDownloadCheck_spaceLeft()
    {
        $storageRepo = new StorageService();

        $this->assertEquals(
            $storageRepo->spaceLeftOnDiskAfterDownloadCheck(1024000000),
            true
        );
    }

    public function test_spaceLeftOnDiskAfterDownloadCheck_noSpaceLeft()
    {
        $storageRepo = new StorageService();

        $this->assertEquals(
            $storageRepo->spaceLeftOnDiskAfterDownloadCheck(102400000000),
            false
        );
    }

}
