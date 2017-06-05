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
		    if (Auth::check()) {
                $baseTable->created_by = Auth::user()->id;
                $baseTable->changed_by = Auth::user()->id;
            }
		});

		static::updating(function($baseTable)
		{
		    if (Auth::check()) {
                $baseTable->changed_by = Auth::user()->id;
            }
        });
	}

}