<?php namespace App\Models;

class BookingStatus extends BaseTable {

    const ID_valid = 1;

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name'];

	protected $guarded = ['id'];

}