<?php namespace App\Models;

use App\Mail\ForwardedSms;
use Log;
use SimpleSoftwareIO\SMS\Facades\SMS;

/**
 * Class Message
 * @package App\Models
 * @property int $id
 * @property string $sender
 * @property string $receiver
 * @property string $content
 * @property string $external_id
 * @property string $source
 * @property string $meta_info
 * @property boolean $is_sent
 * @property boolean $is_incoming
 * @property \DateTime $received_at
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 */
class Message extends BaseTable
{


    // Add your validation rules here
    public static $rules = [
        'receiver' => 'required',
        'content' => 'required',
        'sender_id' => 'required'
    ];


    /**
     * send a message
     * @param string $content
     * @param string $receiver
     * @param string $sender
     * @return bool
     */
    public static function send(string $content, string $receiver, string $sender, string $provider): bool
    {

        if ($provider != 'smssync') {
            $data = new \stdClass();
            $data->content = $content;
            $data->receiver = $receiver;
            $data->sender = $sender;
            SMS::queue($content, $data, function ($sms) use ($data) {
                $sms->to($data->receiver);
                $sms->from($data->sender);
            });

        }


        Log::info('Message sent to ' . $receiver);

        return true;

    }

    /**
     * apply rules to a message
     * @return bool
     */
    public function processMessage(): bool
    {


        return $this->forwardMessage();


    }

    /**
     * @return bool
     */
    public function forwardMessage(): bool
    {

        $forwardingRules = MessageForwardingRule::where('incoming_destination','=',$this->receiver)
            ->get(['provider', 'forwarding_destination']);

        if (!$forwardingRules) {
            return false;
        }

        foreach ($forwardingRules as $forwardingRule) {

            if (MessageForwardingRule::isMobile($forwardingRule->forwarding_destination)) {
                self::send($this->content, $forwardingRule['receiver'], $this->receiver);
            }

            if (MessageForwardingRule::isEMail($forwardingRule->forwarding_destination)) {
                $this->forwardAsEmail($forwardingRule->forwarding_destination);
            }


        }

        return true;
    }

    public function forwardAsEmail ($mailReceiver)
    {

            Mail::to($mailReceiver)
                ->send(new ForwardedSms($this));

            Log::info('Forwarded message from ' . $this->sender . ' to ' . $mailReceiver);


    }

}