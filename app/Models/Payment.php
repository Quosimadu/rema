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

    public function resolution()
    {
        return $this->belongsTo(Resolution::class, 'resolution_id');
    }

    public function payoutPayments()
    {
        return $this->hasMany(Payment::class, 'payout_id', 'id');
    }
}
