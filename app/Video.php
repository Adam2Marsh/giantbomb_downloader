<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Video extends Model
{

    protected $appends = ['human_size', 'downloaded_percentage'];

    public function getHumanSizeAttribute()
    {
        return human_filesize($this->size);
    }

    public function getDownloadedPercentageAttribute()
    {
        return 0;
    }

    /**
     * Get the post that owns the comment.
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
