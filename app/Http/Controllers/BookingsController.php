<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\Listing;
use Illuminate\Support\Facades\Request;
use Session;

class BookingsController extends BaseController {

	/**
	 * Display a listing of bookings
	 *
	 * @return Response
	 */
	public function index()
	{


		if (\Request::has('init')) {
			Session::forget('bookings');
		}
		if (\Request::has('listing_id')) {
			if (\Request::get('listing_id') == 0) {
				Session::forget('bookings.listing_id');
			} else {
				Session::put('bookings.listing_id', \Request::get('listing_id'));
		    }
		}

        $timeOptions = [
            'future' => 'future reservations',
            'past' => 'past reservations'
        ];

		if (\Request::has('time') && isset($timeOptions[\Request::get('time')])) {
			Session::put('bookings.time', \Request::get('time'));
		}

		$bookingQuery = Booking::query()->where('booking_status_id','=',1)->orderBy('arrival_date');
		if (Session::has('bookings.listing_id')) {
        $bookingQuery->where('listing_id','=',Session::get('bookings.listing_id'));
         }
        if (Session::has('bookings.time')) {
            $bookingQuery->ofTime(Session::get('bookings.time'));
        }

		$bookings = $bookingQuery->get();
		$listings = Listing::query()->orderBy('name')->get(['id','name'])->pluck(['name', 'id']);
		$listing_id =  Session::get('bookings.listing_id');
        $time =  Session::get('bookings.time');

		return \View::make('bookings.index', compact('bookings','listings','listing_id','timeOptions','time'));
	}

	/**
	 * Show the form for creating a new booking
	 *
	 * @return Response
	 */
	public function create()
	{

		$listings = Listing::query()->orderBy('name')->get(['id','name'])->pluck('name', 'id');
		return \View::make('bookings.create',compact('listings'));
	}

	/**
	 * Store a newly created booking in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = \Request::all(), Booking::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Booking::create($data);

		return \Redirect::route('bookings');
	}

	/**
	 * Display the specified booking.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$booking = Booking::findOrFail($id);

		return \View::make('bookings.show', compact('booking'));
	}

	/**
	 * Show the form for editing the specified booking.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$booking = Booking::find($id);
		$listings = Listing::query()->orderBy('name')->get(['id','name'])->pluck('name', 'id');
		$bookingStatuses = BookingStatus::all(['id','name'])->pluck('name', 'id');

		return \View::make('bookings.edit', compact('booking','listings','bookingStatuses'));
	}

	/**
	 * Update the specified booking in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$booking = Booking::findOrFail($id);

		$validator = \Validator::make($data = \Request::all(), Booking::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$booking->update($data);

		return \Redirect::route('bookings');
	}

	/**
	 * Remove the specified booking from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Booking::destroy($id);

		return \Redirect::route('bookings');
	}

}
