<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Message;
use Illuminate\Http\Response;

class MessageSmsSyncController extends Controller
{



    public static $syncSmsReceiveRules = [
        'from' => 'required',
        'sent_to' => '',
        'message' => 'required',
        'secret' => 'required',
        'sent_timestamp' => '',
        'message_id' => '',
        'device_id' => ''

    ];

    public function request()
    {

        $task = \Request::get('task');

        Log::info('SMSsync task received: ' . $task);

        $allowedTasks = ['send', 'sent', 'result'];

        if ($task != '' && !in_array($task, $allowedTasks)) {
            $response = [
                "payload" => [
                    "success" => false,
                    "error" => 'Task not allowed'
                ]
            ];

            return $response->json($response)->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($task == '') {

            return self::receiveSMS();

        }

        if ($task == 'result') {

            return self::receiveDeliveryReport();
        }

        if ($task == 'sent') {
            $data = \Request::all();
            Log::info('SMSsync sent task received: ' . json_encode($data));
        }


    }

    /**
     * receive an SMS message from external API
     * @return Response
     */
    public function receiveSMS()
    {


        $data = \Request::all();

        Log::info('SMSsync receiveSMS task received: ' . json_encode($data));


        if (env('SMS_SYNCSMS_SECRET') != $data['secret']) {
            Log::info('Secret passed');
            $response = new Response();
            return $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        $validator = \Validator::make($data = \Request::all(), self::$syncSmsReceiveRules);

        if ($validator->fails()) {

            $response = [
                "payload" => [
                    "success" => false,
                    "error" => $validator
                ]
            ];

            return response()->json($response)->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        Log::info('Validator passed');

        if (!isset($data['device_id'])) {
            $data['device_id'] = null;
        }
        if (!isset($data['sent_to'])) {
            $data['sent_to'] = null;
        }
        if (!isset($data['message_id'])) {
            $data['message_id'] = null;
        }

        $incomingMessage = new Message();
        $incomingMessage->content = $data['message'];
        $incomingMessage->sender = $data['from'];
        $incomingMessage->receiver = $data['sent_to'];
        $incomingMessage->external_id = $data['message_id'];

        unset($data['secret']);
        $incomingMessage->meta_info = json_encode($data);
        $incomingMessage->source = 'syncsms';


        Log::info('Message ID ' . $data['message_id']);

        Log::info('JSON' . json_encode($incomingMessage));

        $success = $incomingMessage->save();


        $incomingMessage->processMessage();

        if (!$success) {
            Log::warning('Message saving failed: ' . json_encode($incomingMessage));

            $response = [
                "payload" => [
                    "success" => false,
                    "error" => 'Message saving failed'
                ]
            ];

            return response()->json($response)->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        }


        $response = [
            "payload" => [
                "success" => true,
                "error" => null
            ]
        ];

        return response()->json($response);


    }

    /**
     * receive delivery report from external API
     * @return Response
     */
    public function receiveDeliveryReport()
    {
        $data = \Request::all();

        Log::info('SMSsync delivery report received: ' . json_encode($data));

    }

    /**
     * send a task list to server
     * @return Response
     */
    public function sendTasks()
    {

        Log::info('SMSsync sendTask request received');

        $messages = [];
        $content = "Sample Task Message";
        $receiver = "+420234095676";

        $messages[] = [
            "to" => $receiver,
            "message" => $content,
            "uuid" => "1ba368bd-c467-4374-bf28"
        ];
        // Send JSON response back to SMSsync
        $response = json_encode(
            ["payload" => [
                "success" => true,
                "task" => "send",
                "secret" => env('SMS_SMSSYNC_SECRET'),
                "messages" => array_values($messages)]
            ]);

        return response()->json($response);

        /*
                $requestDeliveryReports = json_encode(
                    [
                        "message_uuids" => ['1ba368bd-c467-4374-bf28']
                    ]);

        */
    }
}
