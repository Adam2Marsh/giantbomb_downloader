<?php

use Illuminate\Database\Seeder;
use App\Video;
use Carbon\Carbon;

class FillVideoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// for ($i=0; $i < 50; $i++) { 
    	// 	$this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_$i", $i, "test.com", '2016-01-01');
    	// }
        
        $currentDate = Carbon::now();
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 1, "test.com", "DOWNLOADED",$currentDate->subDays(100));

        $currentDate = Carbon::now();        
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_2", 2, "test.com", "NEW",$currentDate->subDays(200));

        $currentDate = Carbon::now();        
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_3", 3, "test.com", "NEW",$currentDate->subDays(10));

        $currentDate = Carbon::now();        
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_4", 4, "test.com", "DOWNLOADED",$currentDate->subDays(1));

    }


    public function CreateVideo($name, $id, $url, $status, $publish_date)
    {
    	$newVideoDownloadStatus = new Video;

        $newVideoDownloadStatus->name = $name;

        // $videoFilename = $this->$name.".mp4";
        $newVideoDownloadStatus->file_name = $name.'mp4';

        $newVideoDownloadStatus->gb_Id = $id;

        $newVideoDownloadStatus->url = $url;

        $newVideoDownloadStatus->published_date = $publish_date;

        $newVideoDownloadStatus->status = $status;

        $newVideoDownloadStatus->save();
    }
}
