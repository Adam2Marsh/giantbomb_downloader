<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 15/02/2018
 * Time: 07:37
 */

namespace App\Services\Video;

use App\Interfaces\VideoServiceInterface;
use App\Repositories\VideoServiceConfigurationRepository;
use App\Repositories\VideoRepository;

class GiantbombVideoService implements VideoServiceInterface
{

    protected $giantbombApi;
    protected $videoServiceConfigurationRepository;
    protected $videoRepository;
    protected $serviceId;

    public function __construct()
    {
        $this->giantbombApi = new GiantbombApi();
        $this->videoServiceConfigurationRepository = new VideoServiceConfigurationRepository();
        $this->videoRepository = new VideoRepository();
        $this->serviceId = returnServiceId('Giantbomb');
    }

    public function register($key)
    {
        if($this->videoServiceConfigurationRepository->getServiceApiKey($this->serviceId) != null) {
            return "Already Registered";
        }

        $apikey = $this->giantbombApi->getApiKey($key);

        $this->videoServiceConfigurationRepository->storeServiceApiKey($this->serviceId, $apikey["api_key"]);
        return "Successful Registration";
    }

    public function fetchLatestVideosFromApi()
    {
        $api_key = $this->videoServiceConfigurationRepository->getServiceApiKey($this->serviceId);

        if(count($api_key) == 0) {
            return "Need to register";
        }

        $url = config('gb.api_address');
        $query = config('gb.api_query');

        $requestURL = "$url".str_replace("KEY_HERE", $api_key, $query);

        $response = getJSON($requestURL.config('gb.max_videos_to_grab_api'));

        $videosAdded = $this->videoRepository->addVideoToDatabase(
            $this->serviceId,
            $response["results"],
            $this->returnVideoToDatabaseMappings()
        );

        return "$videosAdded videos were added for Giantbomb";
    }

    public function returnVideoToDatabaseMappings()
    {
        return [
            "service_video_id" => "id",
            "name" => "name",
            "description" => "deck",
            "publish_date" => "publish_date",
            "thumbnail_url" => "medium_url",
            "video_url" => 
                [
                    "hd_url",
                    "high_url",
                ]
        ];
    }

    public function buildUrl($url)
    {
        return $url. "?api_key=" . $this->videoServiceConfigurationRepository->getServiceApiKey($this->serviceId);
    }
}