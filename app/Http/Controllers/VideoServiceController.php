<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 15/02/2018
 * Time: 07:48
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoServiceController
{

    public function registerService($service, Request $request)
    {
        $newService = "\\App\Services\Video\\".$service."VideoService";
        $service = new $newService;

        return response($service->register($request->key));
    }

    public function fetchVideosFromServices($service)
    {
        $newService = "\\App\Services\Video\\".$service."VideoService";
        $service = new $newService;

        return response($service->fetchLatestVideosFromApi());
    }

    public function toggleService()
    {

    }
    
}