<?php

namespace App\Services;

use GuzzleHttp\Client;
use Log;
use App\Repositories\RulesRepository;
use App\Jobs\DownloadVideoJob;
use App\Video;

use Illuminate\Foundation\Bus\DispatchesJobs;

class DownloadVideoInformation
{

    use DispatchesJobs;

    public function updateVideosInDatabase($url, $query, $api_key)
    {
        $response = "";
        $vsr =  new \App\Repositories\VideoRepository;
        $ruleRepo = new RulesRepository();

        $requestURL = "$url".str_replace("KEY_HERE", $api_key, $query);
        $jsonResponse = $this->getJSON($requestURL);
        $videoResultsArray = $jsonResponse->results;

        foreach ($videoResultsArray as $video)
        {
            if($vsr->checkIfVideoIsInDatabase($video->name))
            {
                Log::info(__METHOD__." ".$video->name." already exists in database, not adding");
                echo $video->name." already exists in database, not adding";
                $response = $video->name." already exists in database, not adding";
            } else
            {
                Log::info(__METHOD__." ".$video->name." doesn't exists in database, adding");
                echo $video->name." doesn't exists in database, adding";
                $response = $video->name." doesn't exists in database, adding";
                $details = "";
                $savedVideo = $vsr->addVideoToDatabase($video, $this->getVideoFileSize($video->hd_url));

                Log::info(__METHOD__." Checking if $video->name matches any rules");
                if($ruleRepo->VideoMatchRules($video->name))  {
                  Log::info(__METHOD__." $video->name matches a rule, downloading");
                  $this->dispatch(new DownloadVideoJob($savedVideo));
                }
            }
            echo "<br>";
        }
        return $response;
        // echo "<pre>".print_r($VideoResultsArray,true)."</pre>";
    }

    function getJSON($JSONUrl){

        Log::info(__METHOD__." Performing GET using Guzzle to ".$JSONUrl);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $JSONUrl);

        if($this->CheckHTTPCallSucessful($res->getStatusCode())) {
            Log::info(__METHOD__." Guzzle Get Request responded with: ".$res->getBody());
            return json_decode($res->getBody());
        }
        else {
            Log::critical(__METHOD__." HTTP Call to ".$JSONUrl." failed, recieved this back".$res->getStatusCode().$res->getReasonPhrase());
        }
    }

    function checkHTTPCallSucessful($HttpStatusCode){
        if($HttpStatusCode != 200){
            return false;
        }
        return true;
    }

    function getVideoFileSize($url)
    {
        Log::info(__METHOD__." Fetching Video Size for video at $url");
        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->request('HEAD', $url);
            if($this->CheckHTTPCallSucessful($res->getStatusCode())) {
                Log::info(__METHOD__." Guzzle HEAD Request responded with: ".$res->getHeader('Content-Length')[0]);
                return $res->getHeader('Content-Length')[0];
            }
            else {
                Log::critical(__METHOD__." HTTP Call to ".$JSONUrl." failed, recieved this back".$res->getStatusCode().$res->getReasonPhrase());
                return 0;
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

}
