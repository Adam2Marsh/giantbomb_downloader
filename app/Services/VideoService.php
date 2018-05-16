<?php

namespace App\Services;

use Storage;
use Log;
use Illuminate\Http\File;
use App\Services\Video;

class VideoService
{
    protected $service;

    public function __construct($service)
    {
        $newService = "\\App\Services\Video\\".$service."VideoService";
        $this->service = new $newService;
    }

    public function downloadThumbnail($video, $filename)
    {
        Log::info("Downloading thumbnail for video " . $video->name);

        if(!thumbnailDownloaded($filename)) {
            $options = array('http' => array('user_agent' => config('app.name')));

            $context = stream_context_create($options);

            Storage::disk('thumbnails')->put($filename, file_get_contents($video->thumbnail_url, false, $context));
        }

        return url('storage/thumbnails/' . $filename);
    }

    public function downloadVideo($url, $savePath)
    {
        Log::info("Downloading video from $url");

        $options = array(
            CURLOPT_FILE => is_resource($savePath) ? $savePath : fopen($savePath, 'w'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_URL => $this->service->buildUrl($url)
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);

        $curlInfo = curl_getinfo($ch);

        if($curlInfo["http_code"] != 200) {
            Log:info(curl_error($ch));
            Throw new \Exception("Failed to download video");
        }

        Log::info("Video downloaded successfully");
    }

    /**
     * Returns File Size in Ocets by sending a Head Request
     *
     * @param $url
     * @return int
     */
    function getVideoFileSize($url)
    {
        Log::info(__METHOD__." Fetching Video Size for video at $url");
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('HEAD', $this->service->buildUrl($url));
            if(CheckHTTPCallSucessful($res->getStatusCode())) {
                Log::info(__METHOD__." Guzzle HEAD Request responded with: ".$res->getHeader('Content-Length')[0]);
                return $res->getHeader('Content-Length')[0];
            }
            else {
                Log::critical(__METHOD__." HTTP Call to ".$url." failed, recieved this back".$res->getStatusCode().$res->getReasonPhrase());
                return 0;
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}