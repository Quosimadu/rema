<?php namespace App\Models;

/**
 * Class Booking
 * @package App\Models
 * @property int $id
 * @property string $confirmation_code
 * @property string $guest_name
 * @property string $guest_country
 * @property string $guest_email
 * @property string $guest_phone
 * @property int $listing_id
 * @property int $people
 * @property int $platform_id
 * @property int $booking_status_id
 * @property \DateTime $inquiry_date
 * @property int $nights
 * @property string $arrival_date
 * @property string $arrival_time
 * @property string $departure_date
 * @property string $departure_time
 * @property int $airbnb_conversation_id
 * @property string $comment *
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 * @property \DateTime $deleted_at
 */
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
	protected $fillable = ['confirmation_code','guest_name','guest_country','guest_email','guest_phone',
		'listing_id','people','platform_id','booking_status_id',
		'inquiry_date','nights', 'arrival_date','arrival_time','departure_date','departure_time',
		'airbnb_conversation_id',
		'comment'];

	protected $guarded = ['id'];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
    ];


	public function bookingStatus()
	{
		return $this->belongsTo(BookingStatus::class);
	}

	public function listing()
	{
		return $this->belongsTo(Listing::class);
	}

	public function platform()
	{
		return $this->belongsTo(Platform::class);
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

    public function resolution()
    {
        return $this->hasOne(Resolution::class, 'booking_id');
    }

    public function scopeFilter($query, $filters)
    {
        if ($dateFrom = array_get($filters, 'date_from')) {
            $query->where('arrival_date', '>=', $dateFrom);
        }
        if ($dateTo = array_get($filters, 'date_to')) {
            $query->where('departure_date', '>=', $dateTo);
        }
        if ($listingsFilter = array_get($filters, 'listings')) {
            $query->where(function($query) use ($listingsFilter) {
                if (($key = array_search('null', $listingsFilter)) !== false) {
                    $query->whereNull('listing_id');
                    array_forget($listingsFilter, $key);
                }
                $query->OrWhereIn('listing_id', $listingsFilter);
            });
        }

        return $query;
    }

    public function paymentHost()
    {
        return $this->hasMany(Payment::class)->where('type_id', PaymentType::ID_HOST);
    }

    public function paymentReservation()
    {
        return $this->hasMany(Payment::class)->where('type_id', PaymentType::ID_RESERVATION);
    }
    public function paymentCleaning()
    {
        return $this->hasMany(Payment::class)->where('type_id', PaymentType::ID_CLEANING);
    }
    public function paymentPayout()
    {
        return $this->hasMany(Payment::class)->where('type_id', PaymentType::ID_PAYOUT);
    }
    public function paymentResolution()
    {
        return $this->hasMany(Payment::class)->where('type_id', PaymentType::ID_RESOLUTION);
    }

}