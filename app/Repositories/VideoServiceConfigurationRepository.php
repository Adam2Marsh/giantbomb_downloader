<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 15/02/2018
 * Time: 08:11
 */

namespace App\Repositories;

use App\Setting;
use Illuminate\Support\Facades\Hash;
use Log;

class VideoServiceConfigurationRepository
{

    public function storeServiceApiKey($service_id, $api_key)
    {
        Log::info("Saving new api_key for $service_id");

        $newSetting = new Setting();
        $newSetting->service_id = $service_id;
        $newSetting->key = "api_key";
        $newSetting->value = $api_key;
        $newSetting->save();

        Log::info("Saved new api_key for $service_id");
    }

    public function getServiceApiKey($service)
    {
        Log::info("Returning api_key for $service");

        $api_key = Setting::where([
            ['service_id', '=', $service],
            ['key', '=', 'api_key']
            ])->first();

        if($api_key == null) {
            return null;
        }
        return $api_key->value;
    }

}