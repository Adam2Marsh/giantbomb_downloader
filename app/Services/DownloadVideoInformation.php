<?php

namespace App\Services;

use App\Repositories\VideoRepository;
use App\Repositories\RulesRepository;
use App\Jobs\DownloadVideoJob;
use Log;

use Illuminate\Foundation\Bus\DispatchesJobs;

class DownloadVideoInformation
{

    use DispatchesJobs;

    /**
     * @param $url
     * @param $query
     * @param $api_key
     * @return string
     */
    public function updateVideosInDatabase($url, $query, $api_key)
    {
        $response = "";
        $videoRepository =  new VideoRepository;
        $ruleRepo = new RulesRepository();
        $getVideoDetails = new GetVideoDetailsService();

        $requestURL = "$url".str_replace("KEY_HERE", $api_key, $query);
        $jsonResponse = getJSON($requestURL);
        $videoResultsArray = $jsonResponse->results;

        foreach ($videoResultsArray as $video)
        {
            if($videoRepository->checkIfVideoIsInDatabase($video->name)) {
                Log::info(__METHOD__." ".$video->name." already exists in database, not adding");
                echo $video->name." already exists in database, not adding";
                $response = $video->name." already exists in database, not adding";
            } else
            {
                Log::info(__METHOD__." ".$video->name." doesn't exists in database, adding");
                echo $video->name." doesn't exists in database, adding";
                $response = $video->name." doesn't exists in database, adding";

                $thumbnail_path = $getVideoDetails->downloadVideoThumbnail(
                    $video->image->small_url,
                    $video->name
                );

                $video_file_size = $this->getVideoFileSize($video->hd_url."?api_key=$api_key");

                $savedVideo = $videoRepository->addVideoToDatabase(
                    $video,
                    $video_file_size,
                    $thumbnail_path
                );

                Log::info(__METHOD__." Checking if $video->name matches any rules");
                if($ruleRepo->VideoMatchRules($video->name)) {
                    Log::info(__METHOD__." $video->name matches a rule, downloading");

                    $videoRepository->updateVideoToDownloadedStatus($savedVideo->id, "QUEUED");

                    $this->dispatch(new DownloadVideoJob($savedVideo));
                }
            }
            echo "<br>";
        }
        return $response;
        // echo "<pre>".print_r($VideoResultsArray,true)."</pre>";
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
            $res = $client->request('HEAD', $url);
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
