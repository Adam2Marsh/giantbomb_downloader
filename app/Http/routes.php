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


Route::get('/', function() {
	return redirect ('/Videos');
});


Route::resource('/Videos','VideoController');

Route::get('NewVideos', 'ServiceCaller@newVideos');
Route::get('ScheduleVideos', 'ServiceCaller@scheduleVideos');


Route::get('/TestVideo', function() {

	if (!File::exists("Frontend_Vid_YouTube.mov")) {
        return Response::make("File does not exist.", 404);
    }

    // $fileContents = File::get("Frontend_Vid_YouTube.mov");
    // $response = Response::make($fileContents, 200);
    // $response->header('Content-Type', "video/mp4");
    // return $response;

    return Response::download("Frontend_Vid_YouTube.mov");
});

Route::get('/Test_Json', function() {
	return '{"error":"OK","limit":1,"offset":0,"number_of_page_results":1,"number_of_total_results":10427,"status_code":1,"results":[{"hd_url":"http:\/\/localhost\/Frontend_Vid_YouTube.mov","id":10924,"name":"Unprofessional Fridays: 02/05/2016","publish_date":"2015-12-18 20:00:00"}],"version":"1.0"}';
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
