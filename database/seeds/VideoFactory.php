<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Video;

class VideoFactory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newVideo = new Video();
        $newVideo->service_id = 1;
        $newVideo->service_video_id = 1;
        $newVideo->name = "VideoModelTest";
        $newVideo->description = "VideoModelTest";
        $newVideo->video_url = "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4";
        $newVideo->thumbnail_url = "http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg";
        $newVideo->size = 11334031;
        $newVideo->state = "NEW";
        $newVideo->published_date = Carbon::now();
        $newVideo->save();
    }
}
