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
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 1, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 2, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 3, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 4, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 5, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 6, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 7, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 8, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 9, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 10, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 11, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 12, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 13, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 14, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 15, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 16, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 17, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 18, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 19, "test.com", '2016-01-01');
        $this->CreateVideo("Kerbal_Project_B.E.A.S.T_-_Part_1", 20, "test.com", '2016-01-01');
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
