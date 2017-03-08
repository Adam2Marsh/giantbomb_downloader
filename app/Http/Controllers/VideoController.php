<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Video;
use Log;
use Storage;

use App\Repositories\VideoRepository;
use App\Jobs\DownloadVideoJob;
use App\Services\VideoStorage;
use App\Services\VideoSizing;

use Carbon\Carbon;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VideoStorage $vs)
    {
        $currentDate = Carbon::now();

        $videos = Video::whereDate("published_date", ">", $currentDate->subDays(config('gb.index_show_days_video')))
                ->orWhere("status", "=", "DOWNLOADED")->orderBy('published_date', 'desc')
                ->paginate();

        $videoSizing = new VideoSizing();
        $videoSizing->getDirectorySize("gb_videos");

        return view('main', ['videos' => $videos,
                            'humanSize' => $videoSizing->returnAsHuman(),
                            'dirPercentage' => $videoSizing->returnAsPercentage(config('gb.storage_limit')),
                            'rawSize' => $videoSizing->returnAsBytes()]);
    }

    /**
     * Download Video manually
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveVideo(Request $request, VideoRepository $vsr)
    {
        $videoID = $request->get('id');

        $video = Video::findOrFail($videoID);
        Log::Info(__METHOD__." I've been asked to download the following $video->name manually, adding to queue");

        $videoName = $vsr->updateVideoToDownloadedStatus($videoID, "QUEUED");

        $this->dispatch(new DownloadVideoJob($video));

        return redirect('/videos')
            ->withSuccess("$video->name added to queue");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $video = Video::findOrFail($id);
//        return response()->download(storage_path("app/gb_videos/$video->file_name"));
        $fs = Storage::getAdapter();

        $file_path = $video->videoDetail->local_path;

        $stream = $fs->readStream($file_path);

        $stream = $stream["stream"];
//        $contents = stream_get_contents($stream);
//        $stream = Storage::get("gb_videos/$video->file_name");

        return response()->stream(
            function() use ($stream) {
//                while(ob_end_flush());
                fpassthru($stream);
            },
            200,
            [
                'Content-Type' => "video/quicktime",
                'Content-disposition' => 'attachment; filename="' . $video->file_name . '"',
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function watched(VideoRepository $vsr, VideoStorage $vs, $id)
    {
        $video = Video::findOrFail($id);
        $videoName = $vsr->updateVideoToDownloadedStatus($video->id, 'WATCHED');

        if ($vs->checkForVideo("gb_videos", $video->file_name)) {
            $vs->deleteVideo("gb_videos", $video->file_name);
        }

        return redirect('/videos')
            ->withSuccess("The  '$videoName' tag has been updated to watched.");
    }
}
