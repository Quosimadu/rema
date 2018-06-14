<?php namespace App\Models;

class Platform extends BaseTable {

    const ID_AIRBNB = 1;

	// Add your validation rules here
	public static $rules = [
		'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	protected $guarded = ['id'];

}