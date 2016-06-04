<?php namespace App\Models;

use SimpleSoftwareIO\SMS\Facades\SMS;

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