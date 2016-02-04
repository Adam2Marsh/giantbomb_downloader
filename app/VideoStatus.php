<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoStatus extends Model
{
    protected $dates = [
    	'created_at',
    	'published_date',
    	'updated_at,'
    ];
}
