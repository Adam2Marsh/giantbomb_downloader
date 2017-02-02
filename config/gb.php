<?php

    return [
        'api_key' => env('GB_API_KEY', ''),
        'max_downloads_per_day' => 5,
        'Website_Address' => 'https://www.giantbomb.com/api/videos/',
        'Latest_Video_Query' => '?api_key=KEY_HERE&format=json&subscriber_only=true&limit=30
          &field_list=id,name,hd_url,publish_date,deck,image',
        'index_show_days_video' => env('INDEX_SHOW_DAYS_VIDEO', 30),
        'storage_limit' => env('STORAGE_LIMIT', 20000000000),
    ];
