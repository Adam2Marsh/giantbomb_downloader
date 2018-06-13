<?php

namespace App\Http\Controllers;

use App\Jobs\FetchNewVideosForAllServices;
use App\Service;
use Illuminate\Http\Request;

class VideoServiceController
{

    public function returnServices()
    {
//        dd(Service::all()[0]->settings);

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

    public function updateService($id, Request $request)
    {
        $rule = Service::findORFail($id);
        $rule->enabled = ($request->enabled == "true") ? 1 : 0;
        $rule->save();
        return response()->json($rule);
    }

    public function registerService($service, Request $request)
    {
        $newService = "\\App\Services\Video\\".$service."VideoService";
        $service = new $newService;

        return response()->json($service->register($request->key));
    }

    public function fetchVideosFromServices()
    {
        dispatch(new FetchNewVideosForAllServices());

        return response("Video Services Refreshed");
    }
    
}