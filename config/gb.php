<?php

    return [
        'api_address' => env('API_ADDRESS', 'https://www.giantbomb.com/api/videos/'),
        'api_query' => env('API_QUERY', '?api_key=KEY_HERE&limit=LIMIT_HERE&format=json&subscriber_only=true&field_list=id,name,hd_url,high_url,low_url,publish_date,deck,image'),
        'max_videos_to_grab_api' => '&limit=' . env('MAX_VIDEOS_TO_GRAB_API', 20),
        'video_download_retry_time'=> env('VIDEO_DOWNLOAD_RETRY_TIME', 5)
    ];
