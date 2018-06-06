<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Video;
use App\Service;
use App\Rule;

class CreateTestDataForTestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createVideo(1, "VideoModelTest", "new");
        $this->createVideo(2, "DiskServiceTest", "downloading");
        $this->createVideo(3, "DiskServiceTest", "downloading");
        $this->createService("VideoServicesRepositoryTest", 0);
        $this->createRule("RuleApiTest");
    }

    public function createVideo($id, $name, $state)
    {
        $newVideo = new Video();
        $newVideo->service_id = 1;
        $newVideo->service_video_id = $id;
        $newVideo->name = $name;
        $newVideo->description = $name;
        $newVideo->video_url = "https://giantbomb-pdl.akamaized.net/video/ft_nonsubs_060311_3500.mp4";
        $newVideo->thumbnail_url = "http://static.giantbomb.com/uploads/scale_small/23/233047/2867124-ddpsu31.jpg";
        $newVideo->size = 11334031;
        $newVideo->state = $state;
        $newVideo->published_date = Carbon::now();
        $newVideo->save();
    }

    public function createService($name, $enabled)
    {
        $newService = new Service();
        $newService->name = $name;
        $newService->enabled = $enabled;
        $newService->apiLink = $name;
        $newService->save();
    }

    public function createRule($rule)
    {
        $newRule = new Rule();
        $newRule->rule = $rule;
        $newRule->enabled = 0;
        $newRule->save();
    }
}
