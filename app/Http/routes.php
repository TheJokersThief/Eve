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


	///////////
	// USERS //
	///////////
	Route::group(['prefix' => 'user'], function(){
        Route::group(['middleware' => 'auth'], function(){
            Route::get('profile', ['as' => 'me', 'uses' => 'UserController@index']);

            Route::get('profile/{name}', 'UserController@userAccount');

            Route::get('editProfile/{encryptedID}', ['as' => 'user/edit', 'uses'=> 'UserController@edit']);
            Route::post('/', ['as' => 'user', 'uses' => 'UserController@updateUserInfo']);

            Route::get('/myEvents', ['as' => 'myEvents', 'uses' => 'UserController@myEvents'] );
            Route::get('/pastEvents', ['as' => 'pastEvents', 'uses' => 'UserController@pastEvents'] );

            Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
        });

        Route::get('/{nameOrId}', ['as' => 'user/show', 'uses' => 'UserController@show']);
	});

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
