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
        $newService->enabled = 1;
        $newService->save();
    }
}
