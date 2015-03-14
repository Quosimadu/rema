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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('rooms',  array('as' => 'listings', 'uses' => 'ListingsController@index'));
Route::any('rooms/add',  array('as' => 'listingCreate', 'uses' => 'ListingsController@create'));
Route::any('rooms/edit/{id}',  array('as' => 'listingEdit', 'uses' => 'ListingsController@edit'));
Route::any('rooms/show/{id}',  array('as' => 'listingShow', 'uses' => 'ListingsController@show'));
Route::resource('listings', 'ListingsController');

Route::get('booking',  array('as' => 'bookings', 'uses' => 'BookingsController@index'));
Route::any('booking/delete/{id}',  array('as' => 'bookingDelete', 'uses' => 'BookingsController@destroy'));
Route::any('booking/add',  array('as' => 'bookingCreate', 'uses' => 'BookingsController@create'));
Route::any('booking/edit/{id}',  array('as' => 'bookingEdit', 'uses' => 'BookingsController@edit'));
Route::any('booking/show/{id}',  array('as' => 'bookingShow', 'uses' => 'BookingsController@show'));
Route::resource('bookings', 'BookingsController');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('fb_auth', function ($facebook = "facebook")
{
	// Get the provider instance
	$provider = Socialize::with($facebook);

	// Check, if the user authorised previously.
	// If so, get the User instance with all data,
	// else redirect to the provider auth screen.
	if (Input::has('code'))
	{
		$user = $provider->user();

		return var_dump($user);
	} else {
		return $provider->redirect();
	}
});