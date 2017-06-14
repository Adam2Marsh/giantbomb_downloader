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

        Log::info(__METHOD__." Fetching Thumbnail at $url for video $name");

        $non_special_name = removeSpecialCharactersFromString($name);

        $thumbnail_name = snake_case($non_special_name);

        Storage::disk('video_thumbnails')
            ->put($thumbnail_name . ".png", file_get_contents($url));

        return "video_thumbnails/$thumbnail_name.png";
    }

    /**
     * Returns File Size in Ocets by sending a Head Request
     *
     * @param $url
     * @return int
     */
    public function getVideoFileSize($url)
    {
        Log::info(__METHOD__." Fetching Video Size for video at $url");
        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->request('HEAD', $url);
            if (CheckHTTPCallSucessful($res->getStatusCode())) {
                Log::info(__METHOD__." Guzzle HEAD Request responded with: ".$res->getHeader('Content-Length')[0]);
                return $res->getHeader('Content-Length')[0];
            } else {
                Log::critical(__METHOD__ .
                    " HTTP Call to ".$url." failed, recieved this back"
                    .$res->getStatusCode().$res->getReasonPhrase());
                return 0;
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
