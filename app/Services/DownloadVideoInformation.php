<?php

namespace App\Services;

use App\VideoStatus; 
use GuzzleHttp\Client;
use Log;

class DownloadVideoInformation
{
    
    function GetJSON($JSONUrl){

        Log::info(__METHOD__." Performing GET using Guzzle to ".$JSONUrl);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $JSONUrl);

        if($this->CheckHTTPCallSucessful($res->getStatusCode())) {
            Log::info(__METHOD__." Guzzle Get Request responded with: ".print_r(json_decode($res->getBody()), true));
            return json_decode($res->getBody());
        }
        else {
            Log::critical(__METHOD__." HTTP Call to ".$JSONUrl." failed, recieved this back".$res->getStatusCode().$res->getReasonPhrase());
            //report("HTTP Call to ".$JSONUrl." failed, recieved this back".$res, 1);
        }
    }

    function CheckHTTPCallSucessful($HttpStatusCode){
        if($HttpStatusCode != 200){
            return false;
        }
        return true;
    }

    function CheckIfVideoIsInDatabase($VideoDetails) {
        Log::info(__METHOD__." Checking if Video ".$VideoDetails->name." is in database");
        $DatabaseResults = \App\VideoDownloadStatus::where('name', $VideoDetails->name)->get();
        Log::info(__METHOD__." Database returned: ".print_r($DatabaseResults, true));

        if($DatabaseResults->isEmpty()) {
            Log::info(__METHOD__." No Results Found");
            return false;
        }
        else {
            Log::info(__METHOD__." Results Found");
            return true;
        }
    }

    function AddVideoToDatabase($VideoDetails) {
        Log::info(__METHOD__." Adding Video ".$VideoDetails->name." into database");

        $newVideoDownloadStatus = new VideoDownloadStatus;
        $newVideoDownloadStatus->name = $VideoDetails->name;
        $newVideoDownloadStatus->gb_Id = $VideoDetails->id;
        $newVideoDownloadStatus->url = $VideoDetails->hd_url;
        $newVideoDownloadStatus->published_date = $VideoDetails->publish_date;
        $newVideoDownloadStatus->status = 'NEW';
        $newVideoDownloadStatus->save();

        Log::info(__METHOD__." Video ".$VideoDetails->name." inserted into database");
    }

}
