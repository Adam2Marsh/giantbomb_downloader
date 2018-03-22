<?php

use Illuminate\Database\Seeder;

use App\Service;

class AddGiantbombService extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newService = new Service();
        $newService->name = "Giantbomb";
        $newService->enabled = 0;
        $newService->apiLink = "https://www.giantbomb.com/app/giantbomb%20pi%20downloader/";
        $newService->save();
    }
}
