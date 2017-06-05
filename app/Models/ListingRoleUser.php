<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ListingRoleUser extends BaseTable {

    // Add your validation rules here
    public static $rules = [
        'listing_id' => 'required',
        'user_id' => 'required',
        'role_id' => 'required'
    ];

    protected $table = 'listings_roles_users';

    // Don't forget to fill this array
    protected $fillable = ['listing_id','user_id','role_id','created_by'];

    protected $guarded = [''];

    public function listings()
    {
        return $this->hasOne('App\Models\Listing','id','listing_id');
    }

    public function roles()
    {
        return $this->hasOne('App\Models\Role','id','role_id');
    }

    public function users()
    {
        return $this->hasOne('App\User','id','user_id');
    }


}
