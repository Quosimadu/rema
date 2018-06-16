<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends BaseTable
{
    protected $guarded = ['id'];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

}
