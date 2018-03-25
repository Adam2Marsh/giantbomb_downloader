<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $appends = ['human_size'];

    public function getHumanSizeAttribute()
    {
        return human_filesize($this->size);
    }

    /**
     * Get the post that owns the comment.
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
