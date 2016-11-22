<?php

namespace App\Services;

use Log;
use Storage;

use GuzzleHttp\Client;
use Illuminate\Http\File;

class GetVideoDetailsService
{

    public function downloadVideoThumbnail($url)
    {
        Log::info(__METHOD__." Fetching Thumbnail at $url");

        return Storage::putFile("public", new File ($url), $imageNam);
    }


    function checkHTTPCallSucessful($HttpStatusCode)
    {
        if($HttpStatusCode != 200) {
            return false;
        }
        return true;
    }

}
