<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\Services\VideoStorage;
use App\Services\VideoSizing;
use App\Repositories\VideoRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HttpEventStreamController extends Controller
{

    public function returnTestStreamPage()
    {
        return view('test.stream');
    }

    public function returnStorageSize(VideoStorage $videoStorage)
    {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cach-Control', 'no-cache');

        $response->setCallback(
            function () {
                $videoStorage = new VideoStorage();
                $videoDirectorySize = new VideoSizing();
                $videoDirectorySize->getDirectorySize("gb_videos");

                echo "data: {";
                echo '"rawSize":"' . $videoDirectorySize->returnAsBytes() . '",';
                echo '"humanSize":"' . $videoDirectorySize->returnAsHuman() . '",';
                echo '"percentage":"' . $videoDirectorySize->returnAsPercentage(config('gb.storage_limit')) . '",';
                echo '"downloading": [';

                $videoRepo = new VideoRepository();
                $videosDownloadling = $videoRepo->returnVideosDownloading();
                for ($i=0; $i < count($videosDownloadling); $i++) {

                    $videoSize = new VideoSizing();
                    $videoSize->getVideoSize($videosDownloadling[$i]->videoDetail->local_path);

                    echo '{"id":"' . $videosDownloadling[$i]->id .  '",';
                    echo '"percentage":"' .
                        $videoSize->returnAsPercentage($videosDownloadling[$i]->videoDetail->file_size)
                        . '"}';

                    if($i < count($videosDownloadling)-1) {
                        echo ",";
                    }
                }

                echo "]}\n\n";
                ob_flush();
                flush();
            }
        );

        return $response;
    }
}
