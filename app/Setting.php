<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
