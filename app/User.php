<?php

namespace App;

use App\Models\ListingRoleUser;
use App\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param int $listing_id
     * @param string $role
     * @return bool
     */
    public function hasListingRole(int $listing_id, string $role): bool
    {


        $userListingRole = ListingRoleUser::whereHas('roles', function ($query) use ($role) {
            $query->where('name', '=', $role);
        })->where('user_id', '=', $this->id)
            ->where('listing_id', '=', $listing_id)
            ->first();

        if ($userListingRole) {
            return true;
        }

        return false;

    }

    public function assignListingRole(int $listing_id, string $role)
    {


    }

    public function removeListingRole(int $listing_id, string $role)
    {

    }
}
