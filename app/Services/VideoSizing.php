<?php

namespace App\Services;

use Log;
use Storage;
use BigFileTools;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Brick\Math\BigDecimal;

class VideoSizing
{

    private $bytes;

    function __construct()
    {
        $this->bytes = BigInteger::of(0);
    }

    public function getVideoSize($pathToVideo)
    {
        if (Storage::exists($pathToVideo)) {
            $file = BigFileTools::createDefault()->getFile(storage_path('app/'.$pathToVideo));
            $this->bytes = $file->getSize();
        } else {
            $this->bytes = 0;
        }

        return $this;
    }

    public function getDirectorySize($pathToDirectory)
    {
        foreach (Storage::allFiles("$pathToDirectory") as $filePath) {
            $file = BigFileTools::createDefault()->getFile(storage_path('app/'.$filePath));

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
