<?php

use Illuminate\Database\Seeder;
use App\VideoStatus;

class FillVideoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 50; $i++) { 
    		$this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_$i", $i, "test.com", '2016-01-01');
    	}
    }


    public function CreateVideo($name, $id, $url, $publish_date)
    {
    	$newVideoDownloadStatus = new VideoStatus;

        $newVideoDownloadStatus->name = $name;

        // $videoFilename = $this->$name.".mp4";
        $newVideoDownloadStatus->file_name = $name.'mp4';

        $newVideoDownloadStatus->gb_Id = $id;

        $newVideoDownloadStatus->url = $url;

        $newVideoDownloadStatus->published_date = $publish_date;

        $newVideoDownloadStatus->status = 'NEW';

        $newVideoDownloadStatus->save();
    }
}
