<?php namespace App\Models;

use SimpleSoftwareIO\SMS\Facades\SMS;

class Message {

	// Add your validation rules here
	public static $rules = [
		'receiver' => 'required',
		'content' => 'required'
	];


	public static function create($message) {

        SMS::send($message, [], function($sms) {
            $sms->to('+mynumber');
        });

	}

}