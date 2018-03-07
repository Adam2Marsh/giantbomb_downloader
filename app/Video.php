<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

//    public function setSizeAttribute($value)
//    {
//        $this->attributes['size'] = human_filesize($value);
//    }

    public function getSizeAttribute($value)
    {
        return human_filesize($value);
    }

    /**
     * Get the post that owns the comment.
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
