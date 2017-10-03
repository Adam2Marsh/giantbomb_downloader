<?php

namespace App\Services;

use App\Config;
use Storage;

class StorageService
{

    protected $disk;

    protected $customStorageLocation;

    public function __construct()
    {
        $this->customStorageLocation = Config::where('name', '=', 'STORAGE_LOCATION')->first();

        if ($this->customStorageLocation && $this->customStorageLocation->value != null) {
            $this->disk = "root";
            $this->customStorageLocation = $this->customStorageLocation->value;
        } else {
            $this->disk = "local";
        }
    }

    public function returnDiskName()
    {
        return $this->disk;
    }

    public function returnPath()
    {
        if ($this->disk == "root") {
            return Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix() .
                "$this->customStorageLocation/";
        } else {
            return storage_path("app/");
        }
    }

    public function spaceLeftOnDiskAfterDownloadCheck($videoSizeInBytes)
    {
        $spaceLeft = disk_free_space($this->returnPath()) - $videoSizeInBytes;

        if ($spaceLeft < 1024000000) {
            return false;
        }

        return true;
    }
}
