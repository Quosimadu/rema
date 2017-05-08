<?php namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageTemplate;
use App\Models\Provider;
use Illuminate\Http\Request;
use SimpleSoftwareIO\SMS\SMS;
use Illuminate\Http\Response;
use Log;


class MessagesController extends BaseController
{


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

        $providers = Provider::query()->orderBy('last_name')->get(['mobile', 'last_name', 'first_name'])->all();
        foreach ($providers as $provider) {
            $providers_formatted[$provider->mobile] = $provider->last_name . ', ' . $provider->first_name;
        }
        $providers = ['' => ''] + $providers_formatted;

        $message_templates = MessageTemplate::query()->orderBy('name')->get(['id', 'name', 'content', 'comment'])->all();


        return \View::make('messages.compose', compact('providers', 'message_templates'));
    }

    /**
     * Store a newly created item in storage
     *
     * @return Response
     */
    public function send()
    {
        $validator = \Validator::make($data = \Request::all(), Message::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        if (Message::send($data)) {
            Message::create($data);
        } else {
            return \Redirect::back()->withErrors("Message could not be sent")->withInput();
        }

        return \Redirect::route('messages');
    }


    /**
     * receive an SMS message from external API
     * @return Response
     */
    public function receiveSMS()
    {

        Log::info('Message request received: ');



        $inbound = new SMS('nexmo');
        #$inbound->driver('nexmo');
#        $inbound->receive();
        /*


        $incomingMessage = new Message();
        $incomingMessage->content = $inbound->message();
        $incomingMessage->sender = $inbound->from();
        $incomingMessage->receiver = $inbound->to();
        $incomingMessage->external_id = $inbound->id();
        $incomingMessage->meta_info = $inbound->raw();

        Log::info('Message: ' . json_encode($incomingMessage));
        $success = $incomingMessage->save();
*/
        $incomingMessage = [];
        $success = true;

        if (!$success) {
            Log::warning('Message saving failed: ' . json_encode($incomingMessage));

            $response = new Response();
            return $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        }


        #Log::info('Message saved: ' . json_encode($incomingMessage));
        $response = new Response();
        return $response->setStatusCode(Response::HTTP_OK);



    }

}
