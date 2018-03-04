<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Video;
use App\Repositories\VideoRepository;

class VideosController extends Controller
{
    public function returnAllVideos()
    {
        return response()->json(Video::limit(100)->orderBy('published_date', 'desc')->get());
    }

    public function downloadVideo($id, VideoRepository $videoServiceVideoRepository)
    {
        return response($videoServiceVideoRepository->updateVideoState($id, "downloaded"));
    }

    public function deleteVideoLocally($id, VideoRepository $videoServiceVideoRepository)
    {
        return response($videoServiceVideoRepository->updateVideoState($id, "watched"));
    }
}
