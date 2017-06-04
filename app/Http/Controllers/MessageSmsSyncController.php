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

    public static function authorizeRequest(): bool
    {
        $secret = \Request::get('secret');
        if (env('SMS_SYNCSMS_SECRET') != $secret) {
            return false;
        }

        return true;
    }

    public static function returnNotAuthorized(): Response
    {

        $response = new Response();
        return $response->setStatusCode(Response::HTTP_UNAUTHORIZED);

    }

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

            if (!self::authorizeRequest()) {
                return self::returnNotAuthorized();
            }
            return self::receiveSMS();

        }

        if ($task == 'send' && \Request::isMethod('POST')) {

            return self::receiveSMS();
        }


        if ($task == 'result' && \Request::isMethod('GET')) {

            if (!self::authorizeRequest()) {
                return self::returnNotAuthorized();
            }

            return self::requestDeliveryReports();
        }

        if ($task == 'result' && \Request::isMethod('POST')) {

            if (!self::authorizeRequest()) {
                return self::returnNotAuthorized();
            }

            return self::receiveDeliveryReports();
        }

        /* app confirms that messages were queued for sending */
        if ($task == 'sent' && \Request::isMethod('POST')) {

            return self::confirmQueuedMessages();
        }

        /* app asks for jobs */
        if ($task == 'send' && \Request::isMethod('GET')) {

            if (!self::authorizeRequest()) {
                return self::returnNotAuthorized();

            }
            return self::sendTasks();

        }


    }

    /**
     *
     * @return JsonResponse
     */
    public static function receiveDeliveryReports(): JsonResponse
    {
        $data = \Request::all();

        $response = [
            "payload" => [
                "success" => false,
                "error" => ''
            ]
        ];

        if (empty($data['message_result'])) {
            return response()->json($response);
        }


        $messageResults = json_decode($data['message_result']);


        foreach ($messageResults as $messageResult) {

            if ($messageResult->sent_result_code > 0
                || $messageResult->delivered_result_code > 0
                || $messageResult->delivered_result_message != "SMS delivered"
            ) {
                continue;
            }

            $message = Message::where('id', '=', $messageResult->uuid)
                ->where('is_sent', '=', '1')
                ->where('is_incoming', '=', '0')
                ->whereNull('received_at')
                ->where('source', '=', 'smssync')
                ->first();

            if ($message) {
                $message->received_at = DB::raw('NOW()');
                $message->save();
            }
        }


        $response = [
            "payload" => [
                "success" => true,
                "error" => ''
            ]
        ];

        Log::info('JSON response: ' . json_encode($response));


        return response()->json($response);


    }

    /**
     * SMSSync confirms queuing messages after fetching them with send()
     * it'll not send them out unless it gets green here
     * @return JsonResponse
     */
    public static function confirmQueuedMessages(): JsonResponse
    {
        $data = \Request::all();

        $confirmedMessages = [];

        if (is_array($data['queued_messages']) && count($data['queued_messages']) > 0) {

            foreach ($data['queued_messages'] as $message_id) {
                $message = Message::where('id', '=', $message_id)
                    ->where('is_sent', '=', 'false')
                    ->where('is_incoming', '=', 'false')
                    ->where('source', '=', 'smssync')
                    ->first();
                if ($message) {
                    $message->is_sent = true;
                    $message->save();
                    $confirmedMessages[] = $message_id;
                }
            }

        }

        $response = [
            'message_uuids' => $confirmedMessages
        ];

        return response()->json($response);


    }

    /**
     * receive an SMS message from external API
     * @return Response
     */
    public function receiveSMS(): JsonResponse
    {


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

        $messages = DB::table('message_senders')
            ->join('messages', 'message_senders.number', '=', 'messages.sender')
            ->select('messages.*')
            ->where('messages.is_sent', '=', '1')
            ->where('messages.is_incoming', '=', '0')
            ->whereNull('messages.received_at')
            ->where('messages.source', '=', 'smssync')
            ->get(['id']);


        $outstandingDeliveryReports = [];

        foreach ($messages as $message) {
            $outstandingDeliveryReports[] = $message->id;

        }

        $return = [
            'message_uuids' => $outstandingDeliveryReports
        ];

        Log::info('JSON return: ' . json_encode($return));


        return response()->json($return);

    }

    /**
     * send a task list to server
     * @return Response
     */
    public function sendTasks(): JsonResponse
    {


        $messages = DB::table('message_senders')
            ->join('messages', 'message_senders.number', '=', 'messages.sender')
            ->select('messages.*')
            ->where('messages.is_sent', '=', '0')
            ->where('messages.is_incoming', '=', '0')
            ->where('messages.source', '=', 'smssync')
            ->get(['id', 'sender', 'receiver', 'content']);


        $messageQueue = [];

        foreach ($messages as $message) {
            $messageQueue[] = [
                "to" => $message->receiver,
                "message" => $message->content,
                "uuid" => $message->id,
            ];
        }


        $response = [
            'payload' => [
                'success' => true,
                'task' => "send",
                'secret' => env('SMS_SYNCSMS_SECRET'),
                'messages' => array_values($messageQueue)]
        ];

        return response()->json($response);


    }
}
