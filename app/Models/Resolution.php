<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolution extends BaseTable
{
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function payment()
    {
        return $this->hasOne(Resolution::class, 'resolution_id');
    }

}
