<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BaseTable extends Model {

	protected $guarded = ['created_by','updated_by'];

	public static function boot()
	{
		parent::boot();

		static::creating(function($baseTable)
		{
			#$baseTable->create_user_id = Auth::user()->id;
			#$baseTable->last_change_user_id = Auth::user()->id;
		});

		static::updating(function($baseTable)
		{
			#$baseTable->last_change_user_id = Auth::user()->id;
		});
	}

}