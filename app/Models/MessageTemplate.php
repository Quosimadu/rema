<?php namespace App\Models;

class MessageTemplate extends BaseTable {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'content' => 'required',
	];

	// Don't forget to fill this array
	protected $fillable = ['name','content','comment'];

	protected $guarded = ['id'];
}