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

	////////////
	// EVENTS //
	////////////
	Route::resource('events', 'EventsController');
	Route::get('events/upload/{encryptedEventID}', ['as' => 'media/upload', 'uses' => 'MediaController@uploadFiles']);

	//////////////
	// PARTNERS //
	//////////////
	Route::resource('partners', 'PartnersController');

	//////////
	// NEWS //
	//////////
	Route::resource('news', 'NewsController');

	///////////////
	// LOCATION  //
	///////////////
	Route::resource('locations', 'LocationController');

	///////////
	// ADMIN //
	///////////
	Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function( ){
		Route::get('/', ['as' => 'admin.home', 'uses' => 'AdminController@index']);
		Route::get('unprocessed', ['as' => 'media.unprocessed', 'uses' => 'MediaController@viewUnprocessedMedia']);
		Route::get('unprocessed/{eventID}', ['as' => 'media.unprocessedForEvent', 'uses' => 'MediaController@viewUnprocessedMediaForEvent']);
	});

	Route::group(['prefix' => 'staff', 'middleware' => ['staff']], function( ){
		Route::get('/', ['as' => 'staff.home', 'uses' => 'StaffController@index']);

		Route::get("toPrint", 'TicketController@ticketsToPrint');
		Route::get("markPrinted/{id}", 'TicketController@markPrinted');
		Route::get("nameTag/{id}", 'TicketController@printableNameTag');
	});



	///////////
	// USERS //
	///////////
	Route::group(['prefix' => 'user'], function(){
        Route::group(['middleware' => 'auth'], function(){
            Route::get('profile', ['as' => 'me', 'uses' => 'UserController@index']);

            Route::get('editProfile/{encryptedID}', ['as' => 'user/edit', 'uses'=> 'UserController@edit']);
            Route::post('/{encryptedID}', ['as' => 'user', 'uses' => 'UserController@updateUserInfo']);

            Route::get('/myEvents', ['as' => 'myEvents', 'uses' => 'UserController@myEvents'] );
            Route::get('/pastEvents', ['as' => 'pastEvents', 'uses' => 'UserController@pastEvents'] );

            Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);

             Route::get('test', ['as' => 'test', 'uses' => 'UserController@test']);
            Route::get('search', ['as' => 'search', 'uses' => 'UserController@search']);
        });
        Route::get('show/{nameOrId}', ['as' => 'user/show', 'uses' => 'UserController@show']);
	});

	//////////////////////
	// SEARCH FUNCTION ///
	//////////////////////
    Route::get('search', ['as' => 'search', 'uses' => 'UserController@search']);

});

Route::group(['prefix' => 'tickets', 'middleware' => 'web'], function(){
	Route::post('/', 'TicketController@store');
    Route::get('verify/{code}', 'TicketController@verify');
    Route::get('ical/{code}', 'TicketController@iCal');
    Route::get('print/{id}', [ 'as' => 'tickets/print', 'uses' => 'TicketController@printable']);
    Route::get('{id}', 'TicketController@show');
});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
	Route::group(['prefix' => 'install'], function () {
		Route::post('createuser', 'ApiController@installCreateUser');
		Route::get('getInstallUserInfo', 'ApiController@getInstallUserInfo');
		Route::post('createCompany', 'ApiController@createCompany');
	});

	Route::group(['prefix' => 'location', 'middleware' => 'admin'], function () {
		Route::post('create', 'ApiController@createLocation');
        Route::get('create', 'ApiController@createLocation');

    });

	Route::group(['prefix' => 'media', 'middleware' => 'admin'], function () {
		Route::post('approve', 'ApiController@approveMedia');
	});

	Route::group(['prefix' => 'media', 'middleware' => 'auth'], function(){
		Route::post('upload/{encryptedEventID}', ['as' => 'api/media/upload', 'uses' => 'ApiController@uploadMedia']);
		Route::post('rename', ['as' => 'api/media/rename', 'uses' => 'ApiController@renameMedia']);
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

// Event photos are divided by hashed event id
Route::get('event-photos/{directory}/{image}', function( $directory, $image = null)
{
	$path = storage_path(). '/event-photos/'. $directory .'/' . $image;
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
