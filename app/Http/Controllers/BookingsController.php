<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\Listing;

class BookingsController extends BaseController {

	/**
	 * Display a listing of bookings
	 *
	 * @return Response
	 */
	public function index()
	{
		$bookings = Booking::query()->where('booking_status_id','=',1)->orderBy('arrival_date')->get();

		return \View::make('bookings.index', compact('bookings'));
	}

	/**
	 * Show the form for creating a new booking
	 *
	 * @return Response
	 */
	public function create()
	{

		$listings = Listing::query()->orderBy('name')->get(['id','name'])->lists('name', 'id');
		return \View::make('bookings.create',compact('listings'));
	}

	/**
	 * Store a newly created booking in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = \Input::all(), Booking::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Booking::create($data);

		return \Redirect::route('bookings.index');
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
		$listings = Listing::query()->orderBy('name')->get(['id','name'])->lists('name', 'id');
		$bookingStatuses = BookingStatus::all(['id','name'])->lists('name', 'id');

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

		$validator = \Validator::make($data = \Input::all(), Booking::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$booking->update($data);

		return \Redirect::route('bookings.index');
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

		return \Redirect::route('bookings.index');
	}

}
