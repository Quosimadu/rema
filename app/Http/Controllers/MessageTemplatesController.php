<?php namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use Illuminate\Http\Request;

class MessageTemplatesController extends BaseController {

	/**
	 * Display a listing of MessageTemplates
	 *
	 * @return Response
	 */
	public function index()
	{
		$message_templates = MessageTemplate::all();

		return \View::make('message_templates.index', compact('message_templates'));
	}

	/**
	 * Show the form for creating a new provider
	 *
	 * @return Response
	 */
	public function create()
	{

		return \View::make('message_templates.create');
	}

	/**
	 * Store a newly created provider in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = \Request::all(), MessageTemplate::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		MessageTemplate::create($data);

		return \Redirect::route('message_templates');
	}

	/**
	 * Display the specified provider.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$message_template = MessageTemplate::findOrFail($id);

		return \View::make('message_templates.show', compact('message_template'));
	}

	/**
	 * Show the form for editing the specified provider.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$message_template = MessageTemplate::find($id);

		return \View::make('message_templates.edit', compact('message_template'));
	}

	/**
	 * Update the specified provider in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$message_template = MessageTemplate::findOrFail($id);

		$validator = \Validator::make($data = Request::all(), MessageTemplate::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$message_template->update($data);

		return \Redirect::route('message_templates');
	}

	/**
	 * Remove the specified provider from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		MessageTemplate::destroy($id);

		return \Redirect::route('message_templates');
	}

}
