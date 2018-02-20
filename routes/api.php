<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/videos/all', 'VideosController@returnAllVideos');

Route::post('/{service}/register', 'VideoServiceController@registerService');
Route::get('/{service}/fetch', 'VideoServiceController@fetchVideosFromServices');
