<?php

use Illuminate\Database\Seeder;

use App\Setting;

class AddBaseOptions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newSetting = new Setting();
        $newSetting->service_id = 0;
        $newSetting->key = "storage_limit";
        $newSetting->value = "10000000000";
        $newSetting->save();
    }
}
