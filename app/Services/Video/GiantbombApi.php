<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 15/02/2018
 * Time: 07:11
 */

namespace App\Services\Video;

class GiantbombApi
{
    public function getApiKey($linkCode)
    {
        return getJSON(str_replace(
                "KEY_HERE",
                $linkCode,
                "https://www.giantbomb.com/api/validate?link_code=KEY_HERE&format=json")
        );
    }

    public function checkApiKeyIsPremium($apiKey)
    {
        $premiumCheck = getJSON(str_replace(
                "KEY_HERE",
                $apiKey,
                "https://www.giantbomb.com/api/video/2300-8685/?api_key=KEY_HERE&field_list=hd_url&format=json")
        );

        return isset($premiumCheck->results->hd_url);
    }
}