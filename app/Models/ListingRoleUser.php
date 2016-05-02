<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingRoleUser extends BaseTable {

    // Add your validation rules here
    public static $rules = [
        'listing_id' => 'required',
        'user_id' => 'required',
        'role_id' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['listing_id','user_id','role_id','created_by'];

    protected $guarded = [''];

    public function booking()
    {
        return $this->hasOne('Listing');
    }

    public function role()
    {
        return $this->hasOne('Role');
    }

    public function user()
    {
        return $this->hasOne('User');
    }


}
