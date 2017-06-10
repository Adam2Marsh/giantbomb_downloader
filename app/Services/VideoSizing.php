<?php

namespace App\Services;

use App\Repositories\StorageRepository;
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

    protected $storageRepo;

    public function __construct()
    {
        $this->bytes = BigInteger::of(0);

        $this->storageRepo = new StorageRepository();
    }

    public function getVideoSize($pathToVideo)
    {
        $disk = $this->storageRepo->returnDiskName();
        $preFilePath = $this->storageRepo->returnPath();

        if (Storage::disk($disk)->exists($disk == "root" ? $preFilePath.$pathToVideo : $pathToVideo)) {
            $file = BigFileTools::createDefault()->getFile($preFilePath.$pathToVideo);
            $this->bytes = $file->getSize();
        } else {
            $this->bytes = 0;
        }

        return $this;
    }

    public function getDirectorySize($pathToDirectory)
    {
        $disk = $this->storageRepo->returnDiskName();
        $preFilePath = $this->storageRepo->returnPath();

        foreach (Storage::disk($disk)->allFiles("$pathToDirectory") as $filePath) {
//            var_dump("$preFilePath/$filePath");

            $file = BigFileTools::createDefault()->getFile(
                $disk == "root" ? $filePath : "$preFilePath/$filePath"
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
