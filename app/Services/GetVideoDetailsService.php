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
        Log::info(__METHOD__." Fetching Thumbnail at $url");

        Storage::disk('public')
            ->put($name . ".png", file_get_contents("http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg"));

        // return public_path() . "/$name.png";
        return url("$name.png");
    }


    function checkHTTPCallSucessful($HttpStatusCode)
    {
        if($HttpStatusCode != 200) {
            return false;
        }
        return true;
    }

}
