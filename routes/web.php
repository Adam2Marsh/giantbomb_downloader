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


Route::get('/', function () {
    return redirect('/videos');
});

Route::get('NewVideos', 'ServiceCaller@newVideos');

// Route::get('ScheduleVideos', 'ServiceCaller@scheduleVideos');

Route::get('/TestVideo', function () {

    if (!File::exists("Frontend_Vid_YouTube.mov")) {
        return Response::make("File does not exist.", 404);
    }

    return Response::download("Frontend_Vid_YouTube.mov");
});

Route::get('/LargeVideo', function () {

    if (!File::exists("Unprofessional_Fridays_08-26-2016.mp4")) {
        return Response::make("File does not exist.", 404);
    }

    // $fileContents = File::get("Frontend_Vid_YouTube.mov");
    // $response = Response::make($fileContents, 200);
    // $response->header('Content-Type', "video/mp4");
    // return $response;

    return Response::download("Unprofessional_Fridays_08-26-2016.mp4");
});

Route::get('/Test_Json', function () {
    return view('test.test');
});

Route::get('Error', function () {
    abort(404);
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
    Route::resource('/rules', 'RuleController');

    Route::get('/videos', 'VideoController@index');
    Route::post('/videos', 'VideoController@saveVideo');
    Route::get('/videos/{id}', 'VideoController@download');
    Route::delete('/videos/{id}', 'VideoController@watched');

    Route::get('/stream', 'HttpEventStreamController@returnStorageSize');
    Route::get('/streamTest', 'HttpEventStreamController@returnTestStreamPage');
});
