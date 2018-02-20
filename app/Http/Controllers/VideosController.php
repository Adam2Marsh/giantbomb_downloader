<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Video;

class VideosController extends Controller
{
    public function returnAllVideos()
    {
        return response()->json(Video::all());
    }
}
