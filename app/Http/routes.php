<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	Route::auth();


Route::get('/', function () {
	return view('welcome');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(array('prefix' => 'rooms', 'middleware' => 'auth'), function() {
	Route::get('/',  array('as' => 'listings', 'uses' => 'ListingsController@index'));
	Route::any('/add',  array('as' => 'listingCreate', 'uses' => 'ListingsController@create'));
	Route::any('/edit/{id}',  array('as' => 'listingEdit', 'uses' => 'ListingsController@edit'));
	Route::any('/show/{id}',  array('as' => 'listingShow', 'uses' => 'ListingsController@show'));
	Route::resource('listings', 'ListingsController');
});

Route::group(array('prefix' => 'providers', 'middleware' => 'auth'), function() {
	Route::get('/',  array('as' => 'providers', 'uses' => 'ProvidersController@index'));
	Route::any('/add',  array('as' => 'providerCreate', 'uses' => 'ProvidersController@create'));
	Route::any('/edit/{id}',  array('as' => 'providerEdit', 'uses' => 'ProvidersController@edit'));
	Route::any('/show/{id}',  array('as' => 'providerShow', 'uses' => 'ProvidersController@show'));
	Route::resource('providers', 'ProvidersController');
});

Route::group(array('prefix' => 'messages', 'middleware' => 'auth'), function() {
	Route::get('/',  array('as' => 'messages', 'uses' => 'MessagesController@index'));
	Route::any('/compose/{id?}',  array('as' => 'messages.compose', 'uses' => 'MessagesController@compose'));
	Route::post('/send',  array('as' => 'messages.send', 'uses' => 'MessagesController@send'));
});

Route::group(array('prefix' => 'message_templates', 'middleware' => 'auth'), function() {
	Route::get('/',  array('as' => 'message_templates', 'uses' => 'MessageTemplatesController@index'));
	Route::any('/add',  array('as' => 'message_templates.create', 'uses' => 'MessageTemplatesController@create'));
	Route::any('/edit/{id}',  array('as' => 'message_templates.edit', 'uses' => 'MessageTemplatesController@edit'));
	Route::any('/show/{id}',  array('as' => 'message_templates.show', 'uses' => 'MessageTemplatesController@show'));
	Route::resource('message_templates', 'MessageTemplatesController');
});


Route::group(array('prefix' => 'booking', 'middleware' => 'auth'), function() {
	Route::get('/',  array('as' => 'bookings', 'uses' => 'BookingsController@index'));
	Route::any('/delete/{id}',  array('as' => 'bookingDelete', 'uses' => 'BookingsController@destroy'));
	Route::any('/add',  array('as' => 'bookingCreate', 'uses' => 'BookingsController@create'));
	Route::any('/edit/{id}',  array('as' => 'bookingEdit', 'uses' => 'BookingsController@edit'));
	Route::any('/show/{id}',  array('as' => 'bookingShow', 'uses' => 'BookingsController@show'));
    Route::resource('bookings', 'BookingsController');

});


Route::any('reports',  array('as' => 'reports', 'uses' => 'ReportsController@index'));
Route::resource('reports', 'ReportsController');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');