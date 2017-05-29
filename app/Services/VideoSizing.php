<?php

namespace App\Services;

use Log;
use Storage;
use App\Config;
use BigFileTools;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Brick\Math\BigDecimal;

class VideoSizing
{

    private $bytes;

    protected $customStorageLocation;

    protected $disk;

    public function __construct()
    {
        $this->bytes = BigInteger::of(0);

        $this->customStorageLocation = Config::where('name', '=', 'STORAGE_LOCATION')->first();

        if ($this->customStorageLocation && $this->customStorageLocation->value != null) {
            $this->disk = "root";
            $this->customStorageLocation = $this->customStorageLocation->value;
        } else {
            $this->disk = "local";
        }
    }

    public function getVideoSize($pathToVideo)
    {
        if ($this->disk == "root") {
            $preFilePath = Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix()
                . "$this->customStorageLocation/";
        } else {
            $preFilePath = storage_path("app/");
        }

        if (Storage::disk($this->disk)->exists($this->disk == "root" ? $preFilePath.$pathToVideo : $pathToVideo)) {
            $file = BigFileTools::createDefault()->getFile($preFilePath.$pathToVideo);
            $this->bytes = $file->getSize();
        } else {
            $this->bytes = 0;
        }

        return $this;
    }

    public function getDirectorySize($pathToDirectory)
    {
        $preFilePath = "";

        if ($this->disk == "root") {
            $pathToDirectory = "$this->customStorageLocation/$pathToDirectory";
            $preFilePath = Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix() . $pathToDirectory;
        } else {
            $preFilePath = storage_path("app");
        }

//        var_dump($this->disk);

//        dd("$pathToDirectory");

        foreach (Storage::disk($this->disk)->allFiles("$pathToDirectory") as $filePath) {
//            var_dump("$preFilePath/$filePath");

            $file = BigFileTools::createDefault()->getFile(
                $this->disk == "root" ? $filePath : "$preFilePath/$filePath"
            );

            $file_size = $file->getSize();

            $this->bytes = $this->bytes->plus($file_size);
        }

        return $this;
    }

    /**
    *       Return sizes in raw bytes
    */
    public function returnAsBytes()
    {
        return $this->bytes->__toString();
    }

    /**
    *       Return sizes readable by humans
    */
    public function returnAsHuman($decimals = 2)
    {
            $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
            $factor = floor((strlen($this->bytes) - 1) / 3);
            return $this->bytes
                        ->toBigDecimal()
                        ->dividedBy(pow(1024, $factor), 2, RoundingMode::HALF_UP)
                        ->__toString() . @$size[$factor];
    }

    /**
    *       Return filesize as a percentage
    */
    public function returnAsPercentage($totalBytes)
    {
            return $this->bytes->toBigDecimal()
                                ->dividedBy($totalBytes, 2, RoundingMode::HALF_UP)
                                ->multipliedBy(100)
                                ->toBigInteger()
                                ->__toString(). "%";
    }
}
