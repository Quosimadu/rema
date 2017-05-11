<?php

namespace App\Models;

/**
 * Class MessageSender
 * @package App
 * @property int $id
 * @property string $number
 * @property string $name
 * @property string $provider
 */
class MessageSender extends BaseTable
{
    // Add your validation rules here
    public static $rules = [
        'number' => 'required',
        'name' => 'required',
        'provider' => 'required'
    ];
}
