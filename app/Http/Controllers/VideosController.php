<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Video;
use App\Repositories\VideoRepository;
use App\Jobs\BroadcastDiskSpace;

class VideosController extends Controller
{
    public function returnAllVideos()
    {
        return response()->json(Video::limit(100)->orderBy('published_date', 'desc')->get());
    }

    public function updateStatus($id, Request $request, VideoRepository $videoServiceVideoRepository)
    {
        return response($videoServiceVideoRepository->updateVideoState($id, $request->state));
    }

    public function triggerDiskSpaceCheck()
    {
        BroadcastDiskSpace::dispatch();

        return response()->json('Disk Space Job Triggered');
    }

    public function downloadVideo($id)
    {
        $video = Video::findOrFail($id);

        return response()->download(storage_path("app/videos/" . $video->service->name . "/" . localFilename($video->name) . ".mp4"));
    }
}
