<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::resource('/Videos','VideoController');

Route::get('NewVideos', 'ServiceCaller@newVideos');
Route::get('ScheduleVideos', 'ServiceCaller@scheduleVideos');

Route::get('/Test_Json', function() {
	return '{"error":"OK","limit":1,"offset":0,"number_of_page_results":1,"number_of_total_results":10427,"status_code":1,"results":[{"hd_url":"http:\/\/localhost\/Frontend_Vid_YouTube.mov","id":10924,"name":"The Final Giant Bomb Live Show of 2015","publish_date":"2015-12-18 20:00:00"}],"version":"1.0"}';
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
