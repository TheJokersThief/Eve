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
	// Basic auth controls such as password reset
	Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

	Route::get('/', 'HomeController@index');

	Route::group(['prefix' => 'install'], function () {
		Route::get('/', ['as' => 'install', 'uses' => 'InstallationController@index']);
	});

	Route::resource('events', 'EventsController');

	Route::resource('partners', 'PartnersController');

	Route::resource('news', 'NewsController');

	Route::group(['prefix' => 'admin'], function( ){
		Route::get('/', ['as' => 'admin.home', 'uses' => 'AdminController@index']);
	});
	
	Route::group(['middleware' => ['auth']], function(){
		Route::get('user/myEvents', ['as' => 'myEvents', 'uses' => 'UserController@myEvents'] );
		Route::get('user/pastEvents', ['as' => 'pastEvents', 'uses' => 'UserController@pastEvents'] );
	});
	Route::get('unprocessed', ['as' => 'media.unprocessed', 'uses' => 'MediaController@viewUnprocessedMedia']);
	Route::get('unprocessed/{eventID}', ['as' => 'media.unprocessedForEvent', 'uses' => 'MediaController@viewUnprocessedMediaForEvent']);

});

Route::group(['prefix' => 'tickets', 'middleware' => 'web'], function(){
	Route::post('/', 'TicketController@store');
	Route::get('{id}', 'TicketController@show');
	Route::get('verify/{code}', 'TicketController@verify');
	Route::get('ical/{code}', 'TicketController@iCal');
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'install'], function () {
	    Route::post('createuser', 'ApiController@installCreateUser');
	    Route::get('getInstallUserInfo', 'ApiController@getInstallUserInfo');
	    Route::post('createCompany', 'ApiController@createCompany');
	});

    Route::group(['prefix' => 'location'], function () {
		Route::post('create', 'ApiController@createLocation');
	});

	Route::group(['prefix' => 'media'], function () {
		Route::post('approve', 'ApiController@approveMedia');
	});

});

// Gets uploaded files via a public url
Route::get('{directory}/{image}', function( $directory, $image = null)
{
    $path = storage_path(). '/'. $directory .'/' . $image;
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
