<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseTable {

    // Add your validation rules here
    public static $rules = [
        'name' => 'required'
    ];

    protected $guarded = ['id'];

}
