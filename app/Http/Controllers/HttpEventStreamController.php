<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\Services\VideoStorage;
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
                echo "data: {";
                echo '"rawSize":"' . $videoStorage->videoStorageRawSize("gb_videos") . '",';
                echo '"humanSize":"' . $videoStorage->videoStorageHumanSize("gb_videos") . '",';
                echo '"percentage":"' . $videoStorage->videoStorageSizeAsPercentage("gb_videos") . '"';
                echo "}\n\n";
                ob_flush();
                flush();
            }
        );

        return $response;
    }

    public function returnVideoDownloadPercentage($id)
    {
        $videoResponse = new StreamedResponse();
        $videoResponse->headers->set('Content-Type', 'text/event-stream');
        $videoResponse->headers->set('Cach-Control', 'no-cache');

        $videoResponse->setCallback(
            function () {
                // $videoStorage = new VideoStorage();
                echo "data: {";
                echo '"percentage":"' . 100 . '"';
                echo "}\n\n";
                ob_flush();
                flush();
            }
        );

        return $videoResponse;
    }
}
