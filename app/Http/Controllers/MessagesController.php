<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Message;
use App\Models\Provider;

class MessagesController extends BaseController {



	/**
	 * Show the form for creating a new message
	 *
	 * @return Response
	 */
	public function compose()
	{

		$providers = Provider::query()->orderBy('first_name')->get(['id','first_name'])->lists('first_name', 'id');
		return \View::make('messages.compose',compact('providers'));
	}

	/**
	 * Store a newly created booking in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = \Request::all(), Message::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Message::create(\Request::get('content'));

		return \Redirect::route('messages.compose');
	}

}
