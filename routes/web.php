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
})->name('home');

Route::any('/messages/smssync', ['uses' => 'MessageSmsSyncController@request']);
Route::any('receive-sms', ['as' => 'smsInboundApi', 'uses' => 'MessagesController@receiveSMS']);

Route::group(['middleware' => ['auth', 'permissions:admin']], function () {
    Route::group(['prefix' => 'rooms'], function () {
        Route::get('/', ['as' => 'listings', 'uses' => 'ListingsController@index']);
        Route::any('/add', ['as' => 'listingCreate', 'uses' => 'ListingsController@create']);
        Route::any('/edit/{id}', ['as' => 'listingEdit', 'uses' => 'ListingsController@edit']);
        Route::get('/show/{id}', ['as' => 'listingShow', 'uses' => 'ListingsController@show']);
        Route::any('/update/{id}', ['as' => 'listingUpdate', 'uses' => 'ListingsController@update']);
        Route::post('/store', ['as' => 'listingStore', 'uses' => 'ListingsController@store']);
    });

    Route::group(['prefix' => 'time_logs'], function () {
        Route::get('/', ['as' => 'time_logs', 'uses' => 'TimeLogController@index']);
        Route::any('/add', ['as' => 'timeLogCreate', 'uses' => 'TimeLogController@create']);
        Route::post('/store', ['as' => 'timeLogStore', 'uses' => 'TimeLogController@store']);
    });

    Route::group(['prefix' => 'providers'], function () {
        Route::get('/', ['as' => 'providers', 'uses' => 'ProvidersController@index']);
        Route::any('/add', ['as' => 'providerCreate', 'uses' => 'ProvidersController@create']);
        Route::any('/edit/{id}', ['as' => 'providerEdit', 'uses' => 'ProvidersController@edit']);
        Route::get('/find', ['as' => 'providerFind', 'uses' => 'ProvidersController@find']);
        Route::get('/show/{id}', ['as' => 'providerShow', 'uses' => 'ProvidersController@show']);
        Route::any('/update/{id}', ['as' => 'providerUpdate', 'uses' => 'ProvidersController@update']);
        Route::post('/store', ['as' => 'providerStore', 'uses' => 'ProvidersController@store']);
    });

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
        Route::any('/compose/{id?}', ['as' => 'messages.compose', 'uses' => 'MessagesController@compose']);
        Route::post('/send', ['as' => 'messages.send', 'uses' => 'MessagesController@send']);
        Route::get('/show/{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    });

    Route::group(['prefix' => 'message_templates'], function () {
        Route::get('/', ['as' => 'message_templates', 'uses' => 'MessageTemplatesController@index']);
        Route::any('/add', ['as' => 'message_templates.create', 'uses' => 'MessageTemplatesController@create']);
        Route::any('/edit/{id}', ['as' => 'message_templates.edit', 'uses' => 'MessageTemplatesController@edit']);
        Route::any('/show/{id}', ['as' => 'message_templates.show', 'uses' => 'MessageTemplatesController@show']);

        Route::any('/update/{id}', ['as' => 'message_templates.update', 'uses' => 'MessageTemplatesController@update']);
        Route::post('/store', ['as' => 'message_templates.store', 'uses' => 'MessageTemplatesController@store']);
    });

    Route::group(['prefix' => 'message_senders'], function () {
        Route::get('/', ['as' => 'message_senders', 'uses' => 'MessageSenderController@index']);
        Route::any('/add', ['as' => 'message_senders.create', 'uses' => 'MessageSenderController@create']);
        Route::any('/edit/{id}', ['as' => 'message_senders.edit', 'uses' => 'MessageSenderController@edit']);
        Route::any('/update/{id}', ['as' => 'message_senders.update', 'uses' => 'MessageSenderController@update']);
        Route::post('/store', ['as' => 'message_senders.store', 'uses' => 'MessageSenderController@store']);
    });

    Route::group(['prefix' => 'bookings'], function () {
        Route::get('/', ['as' => 'bookings', 'uses' => 'BookingsController@index']);
        Route::any('/delete/{id}', ['as' => 'bookingDelete', 'uses' => 'BookingsController@destroy']);
        Route::any('/add', ['as' => 'bookingCreate', 'uses' => 'BookingsController@create']);
        Route::any('/edit/{id}', ['as' => 'bookingEdit', 'uses' => 'BookingsController@edit']);
        Route::any('/show/{id}', ['as' => 'bookingShow', 'uses' => 'BookingsController@show']);
        Route::any('/update/{id}', ['as' => 'bookingUpdate', 'uses' => 'BookingsController@update']);
        Route::post('/store', ['as' => 'bookingStore', 'uses' => 'BookingsController@store']);
        #Route::resource('bookings', 'BookingsController');

    });
    Route::group(['prefix' => 'reports'], function () {
        Route::any('/', ['as' => 'reports', 'uses' => 'ReportsController@index']);
    });

    Route::get('logs', ['uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
});


