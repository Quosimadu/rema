<?php namespace App\Models;

class Booking extends BaseTable {

	// Add your validation rules here
	public static $rules = [
		'guest_name' => 'required',
		'people' => 'required',
		'platform_id' => 'required',
		'booking_status_id' => 'required',
		'listing_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['guest_name','guest_country','guest_email','guest_phone',
		'listing_id','people','platform_id','booking_status_id',
		'inquiry_date','arrival_date','arrival_time','departure_date','departure_time',
		'airbnb_conversation_id',
		'comment'];

	protected $guarded = ['id'];


	public function bookingStatus()
	{
		return $this->belongsTo('BookingStatus');
	}

	public function listing()
	{
		return $this->belongsTo('Listing');
	}

	public function platform()
	{
		return $this->belongsTo('Platform');
	}

    public function scopeOfTime($query, $time)
    {
        if ($time == 'future') {
            return $query->where('arrival_date', '<=', 'CURDATE()');
        }
        if ($time == 'past') {
            return $query->where('arrival_date', '>', 'CURDATE()');
        }
        return $query;
    }

}