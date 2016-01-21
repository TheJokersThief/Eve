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


Route::group(['middleware' => ['web']], function () {
	Route::auth();
	Route::get('/home', 'HomeController@index');
	Route::get('/user/me', 'UserController@me');
});



Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'HomeController@index');

	Route::group(['prefix' => 'install'], function () {
		Route::get('/', ['as' => 'install', 'uses' => 'InstallationController@index']);
	});

	Route::get('/partners', function () {
		return view('partners');
	});

	Route::resource('events', 'EventsController');
});

Route::group(['prefix' => 'ticket', 'middleware' => 'web'], function(){
	Route::get('{id}', 'TicketController@show');
	Route::get('verify/{code}', 'TicketController@verify');
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'install'], function () {
	    Route::post('createuser', 'ApiController@installCreateUser');
	    Route::get('getInstallUserInfo', 'ApiController@getInstallUserInfo');
	});
});

// Gets uploaded files via a public url
Route::get('images/{image}', function($image = null)
{
    $path = storage_path().'/uploads/' . $image;
    if (file_exists($path)) { 
        return Response::download($path);
    }
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
