<?php

class BookingStatus extends \Rema\BaseTable {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name'];

	protected $guarded = ['id'];

}