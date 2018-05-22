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
Route::get('/videos/space', 'VideosController@triggerDiskSpaceCheck');

Route::post('/video/{id}/updateStatus', 'VideosController@updateStatus');
Route::get('/video/{id}/download', 'VideosController@downloadVideo');

Route::post('/{service}/register', 'VideoServiceController@registerService');
Route::post('/service/{id}/update', 'VideoServiceController@updateService');
Route::get('/services', 'VideoServiceController@returnServices');
Route::get('/{service}/fetch', 'VideoServiceController@fetchVideosFromServices');

Route::get('/rules/all', 'RulesController@returnAll');
Route::post('/rule/add', 'RulesController@addRule');
Route::post('/rule/{id}/delete', 'RulesController@deleteRule');
Route::post('/rule/{id}/update', 'RulesController@updateRule');

Route::get('/settings', 'SettingsController@returnAll');