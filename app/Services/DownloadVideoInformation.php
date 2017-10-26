<?php

namespace App\Services;

use App\Jobs\GetVideoFilesizeJob;
use App\Jobs\GetVideoThumbnailJob;
use App\Repositories\VideoRepository;
use App\Repositories\RulesRepository;
use App\Jobs\DownloadVideoJob;
use Log;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery\Exception;

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

        foreach ($videoResultsArray as $video) {
            if ($videoRepository->checkIfVideoIsInDatabase($video->name)) {
                Log::info(__METHOD__." ".$video->name." already exists in database, not adding");
                echo $video->name." already exists in database, not adding";
                $response = $video->name." already exists in database, not adding";
            } else {
                try {
                    Log::info(__METHOD__ . " " . $video->name . " doesn't exists in database, adding");
                    echo $video->name . " doesn't exists in database, adding";
                    $response = $video->name . " doesn't exists in database, adding";

                    $savedVideo = $videoRepository->addVideoToDatabase($video, $video->image->small_url);

                    $this->dispatch(new GetVideoFilesizeJob($savedVideo));

                    $this->dispatch(new GetVideoThumbnailJob($savedVideo));

                    Log::info(__METHOD__ . " Checking if $video->name matches any rules");
                    if ($ruleRepo->VideoMatchRules($video->name)) {
                        Log::info(__METHOD__ . " $video->name matches a rule, downloading");

                        $videoRepository->updateVideoToDownloadedStatus($savedVideo->id, "QUEUED");

                        $jobDownloadVideo =(new DownloadVideoJob($savedVideo))->OnQueue('video');

                        $this->dispatch($jobDownloadVideo);

                    }
                } catch (\Exception $e) {
                    $response = $video->name . " failed adding video because: $e";
                }
            }
            echo "<br>";
        }
        return $response;
        // echo "<pre>".print_r($VideoResultsArray,true)."</pre>";
    }
}
