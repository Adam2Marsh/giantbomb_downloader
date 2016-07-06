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

        $dirSize = $vs->videoStorageSize("gb_videos");

        $videos = Video::whereDate("published_date", ">", $currentDate->subDays(config('gb.index_show_days_video')))->orWhere("status", "=", "DOWNLOADED")->orderBy('published_date','desc')
                ->paginate();
        return view('main',['videos' => $videos,  'dirSize' => $dirSize]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Download Video manually
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, VideoRepository $vsr)
    {
        $videoID = $request->get('id');

        $video = Video::findOrFail($videoID);
        Log::Info(__METHOD__." I've been asked to download the following $video->name manually, adding to queue");
        $this->dispatch(new DownloadVideoJob($video));

        $videoName = $vsr->updateVideoToDownloadedStatus($videoID, "DOWNLOADING");

        return redirect('/Videos')
            ->withSuccess("$video->name added to queue");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::findOrFail($id);
        return response()->download(storage_path("app/gb_videos/$video->file_name"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoRepository $vsr, VideoStorage $vs, $id)
    {
        $video = Video::findOrFail($id);
        $videoName = $vsr->deleteVideoFromDatabase($video->id);

        if ($vs->checkForVideo("gb_videos", $video->file_name)) {
            $vs->deleteVideo("gb_videos", $video->file_name);
        }

        return redirect('/Videos')
            ->withSuccess("The  '$videoName' tag has been deleted.");
    }
}
