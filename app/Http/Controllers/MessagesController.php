<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Message;
use App\Models\Provider;

class MessagesController extends BaseController {


	/**
	 * Display a listing
	 *
	 * @return Response
	 */
	public function index()
	{
		$messages = Message::all();

		return \View::make('messages.index', compact('messages'));
	}

	/**
	 * Show the form for creating a new item
	 *
	 * @return Response
	 */
	public function compose($id = null)
	{

		$providers = Provider::query()->orderBy('last_name')->get(['mobile','last_name','first_name'])->all();
		foreach ($providers as $provider) {
			$providers_formatted[$provider->mobile] = $provider->last_name . ', ' . $provider->first_name;
		}
		$providers = ['' => ''] + $providers_formatted;
		return \View::make('messages.compose',compact('providers'));
	}

	/**
	 * Store a newly created item in storage
	 *
	 * @return Response
	 */
	public function send()
	{
		$validator = \Validator::make($data = \Request::all(), Message::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		if (Message::send($data)) {
			Message::create($data);
		} else {
			return \Redirect::back()->withErrors("Message could not be sent")->withInput();
		}

		return \Redirect::route('messages');
	}

}
