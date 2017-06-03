<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\JsonResponse;
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

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|Response
     */
    public function request()
    {

        $task = \Request::get('task');

        Log::info('SMSsync task received: ' . $task . ' with method: ' . \Request::method());

        $data = \Request::all();
        Log::info('Data: ' . json_encode($data));

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


        if ($task == '' && \Request::isMethod('POST')) {

            return self::receiveSMS();

        }

        if ($task == 'send' && \Request::isMethod('POST')) {

            return self::receiveSMS();
        }


        if ($task == 'result' && \Request::isMethod('GET')) {

            return self::requestDeliveryReports();
        }

        if ($task == 'result' && \Request::isMethod('POST')) {

            $samplePostValues = [
                "message_result" => [
                    [
                        "uuid" => "052bf515-ef6b-f424-c4ee",
                        "sent_result_code" => 0,
                        "sent_result_message" => "SMSSync Message Sent",
                        "delivered_result_code" => -1,
                        "delivered_result_message" => ""
                    ],
                    [
                        "uuid" => "aada21b0-0615-4957-bcb3",
                        "sent_result_code" => 0,
                        "sent_result_message" => "SMSSync Message Sent",
                        "delivered_result_code" => 0,
                        "delivered_result_message" => "SMS Delivered"
                    ],
                ]
            ];

            return response();
        }

        /* app confirms that messages were queued for sending */
        if ($task == 'sent' && \Request::isMethod('POST')) {

            $example = [
                "queued_messages" => [
                    "aada21b0-0615-4957-bcb3",
                    "1ba368bd-c467-4374-bf28",
                    "95df126b-ee80-4175-a6fb"
                ]
            ];


            $return = [
                'message_uuids' => [
                    '12',
                    '13'
                ]
            ];

            return response()->json($return);
        }

        /* app asks for jobs */
        if ($task == 'send' && \Request::isMethod('GET')) {

            return self::sendTasks();
        }


    }

    /**
     * receive an SMS message from external API
     * @return Response
     */
    public function receiveSMS(): JsonResponse
    {


        $data = \Request::all();

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


        if (!isset($data['device_id'])) {
            $data['device_id'] = null;
        }
        if (!isset($data['sent_to'])) {
            $data['sent_to'] = null;
        }
        if (!isset($data['message_id'])) {
            $data['message_id'] = null;
        }

        if (empty($data['sent_to']) && !empty($data['device_id'])) {
            $data['sent_to'] = '+' . $data['device_id'];
        }

        $incomingMessage = new Message();
        $incomingMessage->content = $data['message'];
        $incomingMessage->sender = $data['from'];
        $incomingMessage->receiver = $data['sent_to'];
        $incomingMessage->external_id = $data['message_id'];
        $incomingMessage->is_incoming = true;


        unset($data['secret']);
        $incomingMessage->meta_info = json_encode($data);
        $incomingMessage->source = 'smssync';


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
     * external app requests delivery reports
     * @return Response
     */
    public function requestDeliveryReports(): JsonResponse
    {

        $return = [
            'message_uuids' => [
                "12",
                "13"
            ]
        ];


        return response()->json($return);

    }

    /**
     * send a task list to server
     * @return Response
     */
    public function sendTasks(): JsonResponse
    {


        $messages = DB::table('message_senders')
            ->join('messages','message_senders.number','=','messages.sender')
            ->select('messages.*')
            ->where('messages.is_sent','=','false')
            ->where('messages.is_incoming','=','false')
            ->get(['id', 'sender', 'receiver', 'content']);


        $messageQueue = [];

        foreach ($messages as $message) {
            $messageQueue[] = [
                "to" => $message['receiver'],
                "message" => $message['content'],
                "uuid" => $message['id'],
            ];
        }


        $response = [
            'payload' => [
                'success' => true,
                'task' => "send",
                'secret' => env('SMS_SMSSYNC_SECRET'),
                'messages' => array_values($messageQueue)]
        ];

        return response()->json($response);


    }
}
