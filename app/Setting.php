<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $appends = ['nice_format'];

    public function getNiceFormatAttribute()
    {
        return str_replace('_', ' ', title_case($this->key));
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
