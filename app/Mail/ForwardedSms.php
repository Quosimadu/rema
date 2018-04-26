<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForwardedSms extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Message
     */
    public $textMessage;


    /**
     * ForwardedSms constructor.
     * @param Message $message
     */
    public function __construct(Message $textMessage)
    {
        $this->textMessage = $textMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $subject = trans('messages/forwarding.email_subject', ['sender' => $this->textMessage->sender]);

        return $this->subject($subject)
            ->markdown('emails.message_to_email');
    }
}
