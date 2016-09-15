<?php

namespace App\Services;

use Log;
use Storage;

class VideoSizing
{

    private $bytes;

    function __construct ()
    {
        $this->bytes = 0;
    }

    public function getVideoSize($pathToVideo)
    {
        if(Storage::exists($pathToVideo)) {
            $this->bytes = Storage::size($pathToVideo);
        } else {
            $this->bytes = 0;
        }

        return $this;
    }

    public function getDirectorySize($pathToDirectory)
    {

        foreach (Storage::allFiles("$pathToDirectory") as $file) {
            $file_size = Storage::size($file);

            $file_size = $file_size >= 0 ? $file_size : 4*1024*1024*1024 + $file_size;

            $this->bytes += $file_size;
        }

        return $this;
    }

    /**
    *       Return sizes in raw bytes
    */
    public function returnAsBytes()
    {
        return $this->bytes;
    }

    /**
    *       Return sizes readable by humans
    */
    public function returnAsHuman($decimals = 2)
    {
            $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
            $factor = floor((strlen($this->bytes ) - 1) / 3);

            return sprintf("%.{$decimals}f", $this->bytes  / pow(1024, $factor)) . @$size[$factor];
    }

    /**
    *       Return filesize as a percentage
    */
    public function returnAsPercentage ($totalBytes)
    {
            return round(($this->bytes / $totalBytes) * 100) . "%";
    }

}
