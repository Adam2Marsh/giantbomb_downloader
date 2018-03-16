<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    /**
     * Get all videos for the service.
     */
    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    /**
     * Get all settings for the service.
     */
    public function settings()
    {
        return $this->hasMany('App\Setting');
    }
}
