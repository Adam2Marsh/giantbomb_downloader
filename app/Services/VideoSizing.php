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

    public function __construct()
    {
        $this->bytes = BigInteger::of(0);
    }

    public function getVideoSize($pathToVideo)
    {
        $customStorageLocation = Config::where('name', '=', 'STORAGE_LOCATION')->first()->value;

        if($customStorageLocation) {
            $disk = 'root';
            $preFilePath = Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix()
                . "$customStorageLocation/";
        } else {
            $disk = 'local';
            $preFilePath = storage_path("app/");
        }

        if (Storage::disk($disk)->exists($customStorageLocation ? $preFilePath.$pathToVideo : $pathToVideo)) {
            $file = BigFileTools::createDefault()->getFile($preFilePath.$pathToVideo);
            $this->bytes = $file->getSize();
        } else {
            $this->bytes = 0;
        }

        return $this;
    }

    public function getDirectorySize($pathToDirectory)
    {
        $customStorageLocation = Config::where('name', '=', 'STORAGE_LOCATION')->first()->value;

        $preFilePath = "";

        if($customStorageLocation) {
            $disk = 'root';
            $pathToDirectory = "$customStorageLocation/$pathToDirectory";
            $preFilePath = Storage::disk('root')->getDriver()->getAdapter()->getPathPrefix() . $pathToDirectory;
        } else {
            $disk = 'local';
            $preFilePath = storage_path("app/");
        }

//        var_dump($pathToDirectory);

        foreach (Storage::disk($disk)->allFiles("$pathToDirectory") as $filePath) {

//            var_dump($filePath);

            $file = BigFileTools::createDefault()->getFile(
                $customStorageLocation ? $filePath : "$preFilePath/$filePath"
            );

            $file_size = $file->getSize();

            // $file_size = $file_size >= 0 ? $file_size : 4*1024*1024*1024 + $file_size;

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
