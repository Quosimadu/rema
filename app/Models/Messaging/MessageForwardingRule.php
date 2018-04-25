<?php

namespace App\Models;

/**
 * Class MessageForwardingRule
 * @package App
 * @property int $id
 * @property string $forwarding_destination
 * @property string $incoming_destination
 * @property string $provider
 */
class MessageForwardingRule extends BaseTable
{
    // Add your validation rules here
    public static $rules = [
        'forwarding_destination' => 'required',
        'incoming_destination' => 'required',
        'provider' => 'required'
    ];

    public static function isMobile(string $mobileNumber) : bool
    {
        if (strpos($mobileNumber,'@') !== false) {
            return false;
        }

        return true;
    }

    public static function isEMail(string $emailAddress) : bool
    {
        if (strpos($emailAddress,'@') !== false) {
            return true;
        }

        return false;
    }
}
