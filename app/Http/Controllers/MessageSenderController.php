<?php

namespace App\Http\Controllers;

use App\Models\MessageSender;
use Illuminate\Http\Request;

class MessageSenderController extends Controller
{
    /**
     * Display a listing of MessageTemplates
     *
     * @return Response
     */
    public function index()
    {
        $messageSenders = MessageSender::all();

        return \View::make('message_senders.index', compact('messageSenders'));
    }

    /**
     * Show the form for creating a new item
     *
     * @return Response
     */
    public function create()
    {

        return \View::make('message_senders.create');
    }

    /**
     * Show the form for editing the specified item.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $messageSender = MessageSender::find($id);

        return \View::make('message_senders.create', compact('messageSender'));
    }

    /**
     * Update the specified provider in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $messageSender = MessageSender::findOrFail($id);

        $validator = \Validator::make($data = Request::all(), MessageSender::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $messageSender->update($data);

        return \Redirect::route('message_senders');
    }

    /**
     * Store a newly created item in storage.
     *
     * @param string $id optional
     * @return Response
     */
    public function store(int $id = 0)
    {
        if ($id > 0) {
            return self::update($id);
        }

        $validator = \Validator::make($data = \Request::all(), MessageSender::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        MessageSender::create($data);


        return \Redirect::route('message_senders');
    }

    /**
     * Remove the specified item from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        MessageSender::destroy($id);

        return \Redirect::route('message_senders');
    }
}
