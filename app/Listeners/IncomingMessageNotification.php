<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 25/04/2018
 * Time: 16:59
 */

namespace App\Listeners;


use App\Events\IncomingMessageEvent;

class IncomingMessageNotification
{
    public function __construct()
    {
        //
    }

    public function handle(IncomingMessageEvent $event)
    {

        $event->message->processMessage();
    }
}