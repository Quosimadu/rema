<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Listing;
use App\Http\Requests;
use Illuminate\Http\Request;


class ListingsController extends BaseController {

	/**
	 * Display a listing of listings
	 *
	 * @return Response
	 */
	public function index()
	{
		$listings = Listing::all();

		return \View::make('listings.index', compact('listings'));
	}

	/**
	 * Show the form for creating a new listing
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('listings.create');
	}

	/**
	 * Store a newly created listing in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = \Request::all(), Listing::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Listing::create($data);

		return \Redirect::route('listings.index');
	}

	/**
	 * Display the specified listing.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$listing = Listing::findOrFail($id);

		return \View::make('listings.show', compact('listing'));
	}

	/**
	 * Show the form for editing the specified listing.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$listing = Listing::find($id);

		return \View::make('listings.edit', compact('listing'));
	}

	/**
	 * Update the specified listing in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$listing = Listing::findOrFail($id);
		

		$validator = \Validator::make($data = \Request::all(), Listing::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$listing->update($data);

		return \Redirect::route('listings.index');
	}

	/**
	 * Remove the specified listing from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Listing::destroy($id);

		return \Redirect::route('listings.index');
	}

}
