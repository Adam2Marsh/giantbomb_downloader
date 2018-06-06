<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Video extends Model
{

    protected $appends = ['human_size', 'downloaded_percentage'];

    public function getHumanSizeAttribute()
    {
        return humanFilesize($this->size);
    }

    public function getDownloadedPercentageAttribute()
    {
        $filePath = "videos/" . $this->service->name . "/" . localFilename($this->name) . ".mp4";

        if(Storage::exists($filePath)) {
            return round((Storage::size($filePath) / $this->size) * 100) . "%";
        } else {
            return "0%";
        }
    }

    /**
     * Get the post that owns the comment.
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
