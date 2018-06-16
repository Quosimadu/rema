<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends BaseTable
{
    protected $guarded = ['id'];

    protected $casts = [
        'entry_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
