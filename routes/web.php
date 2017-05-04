<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::group(array('prefix' => 'rooms', 'middleware' => 'auth'), function() {
    Route::get('/', array('as' => 'listings', 'uses' => 'ListingsController@index'));
    Route::any('/add', array('as' => 'listingCreate', 'uses' => 'ListingsController@create'));
    Route::any('/edit/{id}', array('as' => 'listingEdit', 'uses' => 'ListingsController@edit'));
    Route::any('/show/{id}', array('as' => 'listingShow', 'uses' => 'ListingsController@show'));
    Route::any('/update/{id}', array('as' => 'listingUpdate', 'uses' => 'ListingsController@update'));
    Route::post('/store', array('as' => 'listingStore', 'uses' => 'ListingsController@store'));
});

Route::group(array('prefix' => 'providers', 'middleware' => 'auth'), function() {
    Route::get('/',  array('as' => 'providers', 'uses' => 'ProvidersController@index'));
    Route::any('/add',  array('as' => 'providerCreate', 'uses' => 'ProvidersController@create'));
    Route::any('/edit/{id}',  array('as' => 'providerEdit', 'uses' => 'ProvidersController@edit'));
    Route::any('/show/{id}',  array('as' => 'providerShow', 'uses' => 'ProvidersController@show'));
    Route::any('/update/{id}', array('as' => 'providerUpdate', 'uses' => 'ProvidersController@update'));
    Route::post('/store', array('as' => 'providerStore', 'uses' => 'ProvidersController@store'));
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

    Route::any('/update/{id}', array('as' => 'message_templates.update', 'uses' => 'MessageTemplatesController@update'));
    Route::post('/store', array('as' => 'message_templates.store', 'uses' => 'MessageTemplatesController@store'));
});


Route::group(array('prefix' => 'booking', 'middleware' => 'auth'), function() {
    Route::get('/',  array('as' => 'bookings', 'uses' => 'BookingsController@index'));
    Route::any('/delete/{id}',  array('as' => 'bookingDelete', 'uses' => 'BookingsController@destroy'));
    Route::any('/add',  array('as' => 'bookingCreate', 'uses' => 'BookingsController@create'));
    Route::any('/edit/{id}',  array('as' => 'bookingEdit', 'uses' => 'BookingsController@edit'));
    Route::any('/show/{id}',  array('as' => 'bookingShow', 'uses' => 'BookingsController@show'));
    Route::any('/update/{id}', array('as' => 'bookingUpdate', 'uses' => 'BookingsController@update'));
    Route::post('/store', array('as' => 'bookingStore', 'uses' => 'BookingsController@store'));
    #Route::resource('bookings', 'BookingsController');

});


Route::any('reports',  array('as' => 'reports', 'uses' => 'ReportsController@index'));
Route::group(array('prefix' => 'reports', 'middleware' => 'auth'), function() {
    Route::get('/',  array('as' => 'reports', 'uses' => 'ReportsController@index'));
});


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::any('receive-sms', ['uses' => 'MessagesController@receiveSMS']);


