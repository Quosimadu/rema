<?php namespace App\Models;

use SimpleSoftwareIO\SMS\Facades\SMS;

/**
 * Class Message
 * @package App\Models
 * @property string $sender
 * @property string $receiver
 * @property string $content
 * @property string $external_id
 * @property string $source
 * @property string $meta_info
 */
class Message extends BaseTable {



	// Add your validation rules here
	public static $rules = [
		'receiver' => 'required',
		'content' => 'required'
	];


	public static function send($data) {

       /* SMS::send($data->content, [], function($sms) {
            $sms->to('+mynumber');
        });
       */
        return false;

	}

}