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

Route::post('/video/{id}/updateStatus', 'VideosController@updateStatus');

Route::post('/{service}/register', 'VideoServiceController@registerService');
Route::get('/{service}/fetch', 'VideoServiceController@fetchVideosFromServices');

Route::get('/rules/all', 'RulesController@returnAll');
Route::post('/rule/add', 'RulesController@addRule');
Route::post('/rule/{id}/delete', 'RulesController@deleteRule');
Route::post('/rule/{id}/update', 'RulesController@updateRule');

Route::get('/settings/services', 'SettingsController@returnServices');
Route::post('/settings/{id}/update', 'SettingsController@updateService');