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
    return view('test.test');
});

Route::get('Error', function() {
    abort (404);
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
