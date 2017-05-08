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


Route::group(['prefix' => 'rooms', 'middleware' => 'auth'], function() {
    Route::get('/', ['as' => 'listings', 'uses' => 'ListingsController@index']);
    Route::any('/add', ['as' => 'listingCreate', 'uses' => 'ListingsController@create']);
    Route::any('/edit/{id}', ['as' => 'listingEdit', 'uses' => 'ListingsController@edit']);
    Route::any('/show/{id}', ['as' => 'listingShow', 'uses' => 'ListingsController@show']);
    Route::any('/update/{id}', ['as' => 'listingUpdate', 'uses' => 'ListingsController@update']);
    Route::post('/store', ['as' => 'listingStore', 'uses' => 'ListingsController@store']);
});

Route::group(['prefix' => 'providers', 'middleware' => 'auth'], function() {
    Route::get('/',  ['as' => 'providers', 'uses' => 'ProvidersController@index']);
    Route::any('/add',  ['as' => 'providerCreate', 'uses' => 'ProvidersController@create']);
    Route::any('/edit/{id}',  ['as' => 'providerEdit', 'uses' => 'ProvidersController@edit']);
    Route::any('/show/{id}',  ['as' => 'providerShow', 'uses' => 'ProvidersController@show']);
    Route::any('/update/{id}', ['as' => 'providerUpdate', 'uses' => 'ProvidersController@update']);
    Route::post('/store', ['as' => 'providerStore', 'uses' => 'ProvidersController@store']);
});

Route::group(['prefix' => 'messages', 'middleware' => 'auth'], function() {
    Route::get('/',  ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::any('/compose/{id?}',  ['as' => 'messages.compose', 'uses' => 'MessagesController@compose']);
    Route::post('/send',  ['as' => 'messages.send', 'uses' => 'MessagesController@send']);
});

Route::group(['prefix' => 'message_templates', 'middleware' => 'auth'], function() {
    Route::get('/',  ['as' => 'message_templates', 'uses' => 'MessageTemplatesController@index']);
    Route::any('/add',  ['as' => 'message_templates.create', 'uses' => 'MessageTemplatesController@create']);
    Route::any('/edit/{id}',  ['as' => 'message_templates.edit', 'uses' => 'MessageTemplatesController@edit']);
    Route::any('/show/{id}',  ['as' => 'message_templates.show', 'uses' => 'MessageTemplatesController@show']);

    Route::any('/update/{id}', ['as' => 'message_templates.update', 'uses' => 'MessageTemplatesController@update']);
    Route::post('/store', ['as' => 'message_templates.store', 'uses' => 'MessageTemplatesController@store']);
});


Route::group(['prefix' => 'booking', 'middleware' => 'auth'], function() {
    Route::get('/',  ['as' => 'bookings', 'uses' => 'BookingsController@index']);
    Route::any('/delete/{id}',  ['as' => 'bookingDelete', 'uses' => 'BookingsController@destroy']);
    Route::any('/add',  ['as' => 'bookingCreate', 'uses' => 'BookingsController@create']);
    Route::any('/edit/{id}',  ['as' => 'bookingEdit', 'uses' => 'BookingsController@edit']);
    Route::any('/show/{id}',  ['as' => 'bookingShow', 'uses' => 'BookingsController@show']);
    Route::any('/update/{id}', ['as' => 'bookingUpdate', 'uses' => 'BookingsController@update']);
    Route::post('/store', ['as' => 'bookingStore', 'uses' => 'BookingsController@store']);
    #Route::resource('bookings', 'BookingsController');

});


Route::any('reports',  ['as' => 'reports', 'uses' => 'ReportsController@index']);

Route::group(['prefix' => 'reports', 'middleware' => 'auth'], function() {
    Route::get('/',  ['as' => 'reports', 'uses' => 'ReportsController@index']);
});


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::any('receive-sms', ['as' => 'smsInboundApi', 'uses' => 'MessagesController@receiveSMS']);


