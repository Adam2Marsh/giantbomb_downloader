<?php

namespace App\Repositories;

use Log;
use App\Config;

class ConfigRepository
{

    public function UpdateConfig($name, $value) {

        $config = Config::where('name', $name)->first();

        if(isset($config->id)) {

            Log::info(__METHOD__ . " Updating $name to $value");
            $config->value = $value;
        } else {

            Log::info(__METHOD__ . " Creating new config called $name with value of $value");
            $config = new Config();
            $config->name = $name;
            $config->value = $value;
        }

        $config->save();
    }

}
