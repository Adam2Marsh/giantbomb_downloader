<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoDetails extends Model
{

    protected $fillable = ['local_path','image_path','file_size', 'remote_image_path'];

    /**
     * Get the user that owns the phone.
     */
    public function video()
    {
        return $this->belongsTo('App\Video');
    }
}
