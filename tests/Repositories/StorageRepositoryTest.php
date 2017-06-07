<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\StorageRepository;
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
        $storageRepo = new StorageRepository();

        $this->assertEquals("local", $storageRepo->returnDiskName());
    }

    public function test_returnPath_local()
    {
        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '');

        $storageRepo = new StorageRepository();

        $this->assertContains("giantbomb-downloader/storage/app/", $storageRepo->returnPath());
    }


    public function test_returnDiskName_root()
    {
        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '/mnt/external/test');

        $storageRepo = new StorageRepository();

        $this->assertEquals("root", $storageRepo->returnDiskName());
    }

    public function test_returnPath_root()
    {
        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '/mnt/external/test');

        $storageRepo = new StorageRepository();

        $this->assertEquals("//mnt/external/test/", $storageRepo->returnPath());

        $this->configRepo->UpdateConfig('STORAGE_LOCATION', '');
    }

}
