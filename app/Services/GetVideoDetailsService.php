<?php

namespace App\Services;

use Log;
use Storage;

use GuzzleHttp\Client;
use Illuminate\Http\File;

class GetVideoDetailsService
{

    public function downloadVideoThumbnail($url, $name)
    {

        return "Testing";
        Log::info(__METHOD__." Fetching Thumbnail at $url for video $name");

        $non_special_name = removeSpecialCharactersFromString($name);

        $thumbnail_name = snake_case($non_special_name);

        Storage::disk('video_thumbnails')
            ->put($thumbnail_name . ".png", file_get_contents($url));

        return "video_thumbnails/$thumbnail_name.png";
    }

}
