<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class IncomingMessageEvent extends Event
{
    use SerializesModels;


    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}
