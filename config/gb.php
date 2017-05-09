<?php

    return [
        'max_downloads_per_day' => 5,
        'api_address' => env('API_ADDRESS', 'https://www.giantbomb.com/api/videos/'),
        'api_query' => env('API_QUERY', '?api_key=KEY_HERE&format=json&subscriber_only=true
                &field_list=id,name,hd_url,high_url,low_url,publish_date,deck,image'),
        'max_videos_to_grab_api' => '&limit=' . env('MAX_VIDEOS_TO_GRAB_API', 20),
        'index_show_days_video' => env('INDEX_SHOW_DAYS_VIDEO', 90),
        'storage_limit' => env('STORAGE_LIMIT', 20000000000),
        'use_wget_to_download' => env('USE_WGET', true),
    ];
