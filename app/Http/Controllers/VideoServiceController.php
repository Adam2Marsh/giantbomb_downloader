<?php

namespace App\Http\Controllers;

use App\Jobs\FetchNewVideosForAllServices;
use App\Service;
use Illuminate\Http\Request;

class VideoServiceController
{

    /**
     * Returns all the services supported
     * @return mixed
     */
    public function returnServices()
    {
        $services = Service::all();

        $formattedServices = [];

        foreach ($services as $service) {

            $apikey = "";

            foreach ($service->settings as $setting) {
                if($setting->name = "api_key") {
                    $apikey = $setting->value;
                }
            }

            array_push($formattedServices,
                [
                    "id" => $service->id,
                    "name" => $service->name,
                    "enabled" => $service->enabled,
                    "apiLink" => $service->apiLink,
                    "apiKey" => $apikey,
                ]);
        }

        return response()->json($formattedServices);
    }

    /**
     * Enables or disables a Service
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateService($id, Request $request)
    {
        $service = Service::findORFail($id);
        $service->enabled = ($request->enabled == "true") ? 1 : 0;
        $service->save();
        return response()->json($service);
    }

    /**
     * Registers a service with an API Keys so it can be used
     *
     * @param $service
     * @param Request $request
     * @return mixed
     */
    public function registerService($service, Request $request)
    {
        $newService = "\\App\Services\Video\\".$service."VideoService";
        $serviceClass = new $newService;
        $serviceClass->register($request->key);

        $serviceModal = Service::where('name', '=', $service)->first();
        $serviceModal->enabled = 1;
        $serviceModal->save();

        return response()->json("Service Registered and Enabled");
    }

    /**
     * Fetches all new videos from all enabled services
     *
     * @return mixed
     */
    public function fetchVideosFromServices()
    {
        dispatch(new FetchNewVideosForAllServices());

        return response()->json("Video Services Refreshed");
    }
    
}