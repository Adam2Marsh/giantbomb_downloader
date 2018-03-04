<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 28/02/2018
 * Time: 16:56
 */

namespace App\Repositories;

use App\VideoService;
use Log;

class VideoServicesRepository
{

    protected $service;

    public function __construct($service)
    {
        $this->service = VideoService::where('service', '=', $service)->first();
    }

    public function toggleService($state)
    {
        Log::info('Update ' . $this->service->name . " to new state of $state");
        $this->service->enabled = $state;
        $this->service->save();
    }

}