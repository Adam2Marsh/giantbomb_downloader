<?php

use Illuminate\Database\Seeder;

use App\VideoService;

class AddGiantbombService extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newService = new VideoService();
        $newService->service = "Giantbomb";
        $newService->enabled = 1;
        $newService->save();
    }
}
