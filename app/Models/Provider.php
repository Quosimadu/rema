<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends BaseTable
{
    use SoftDeletes;

    protected $fillable = ['first_name','last_name','email','mobile', 'comment','address'];

    protected $dates = ['deleted_at'];


    public static function boot()
    {
        parent::boot();

        static::creating(function($providerTable)
        {
            #$baseTable->last_change_user_id = Auth::user()->id;
        });

    }
}
