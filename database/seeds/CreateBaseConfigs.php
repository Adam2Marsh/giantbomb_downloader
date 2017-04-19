<?php

use Illuminate\Database\Seeder;

class CreateBaseConfigs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'name' => 'SLACK_HOOK_URL',
            'value' => 'NOTSET'
        ]);
    }
}
