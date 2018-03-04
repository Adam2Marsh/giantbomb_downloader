<?php

namespace App\Services;

use Storage;
use Log;
use Illuminate\Http\File;

class VideoService
{

    public function downloadThumbnail($video, $filename)
    {
        Log::info("Downloading thumbnail for video " . $video->name);

        $options  = array('http' => array('user_agent' => config('app.name')));
        $context  = stream_context_create($options);

        Storage::disk('thumbnails')->put($filename, file_get_contents($video->thumbnail_url, false, $context));

        return url('storage/thumbnails/' . $filename);
    }
}