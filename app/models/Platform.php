<?php

class Platform extends \Rema\BaseTable {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	protected $guarded = ['id'];

}