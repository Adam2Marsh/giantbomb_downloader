<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Video;
use Log;

use App\Repositories\VideoRepository;
use App\Jobs\DownloadVideoJob;
use App\Services\VideoStorage;

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

        return view('main', ['videos' => $videos,
                            'humanSize' => $vs->videoStorageHumanSize("gb_videos"),
                            'dirPercentage' => $vs->videoStorageSizeAsPercentage("gb_videos"),
                            'rawSize' => $vs->videoStorageRawSize("gb_videos")]);
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

        $videoName = $vsr->updateVideoToDownloadedStatus($videoID, "SAVING");

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
        return response()->download(storage_path("app/gb_videos/$video->file_name"));
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
