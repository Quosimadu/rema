<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Listing
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $airbnb_name
 * @property int $guests
 * @property int $beds
 * @property string $address
 * @property \DateTime $check_in_time
 * @property \DateTime $check_out_time
 * @property int $airbnb_listing_id
 * @property string $split
 * @property int $is_active
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 * @property \DateTime $deleted_at
 */
class Listing extends BaseTable
{

    use SoftDeletes;


    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'address' => 'required',
        'guests' => 'required',
        'beds' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['name', 'airbnb_name', 'guests', 'beds', 'address', 'check_in_time', 'check_out_time', 'airbnb_listing_id', 'is_active', 'split'];

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function bookings()
    {
        return $this->hasMany('Booking');
    }

    public function timeLogs()
    {
        return $this->hasMany('TimeLog');
    }

    public function getCostCenters()
    {
        if (!empty($this->split)) {
            return json_decode($this->split, true);
        }

        return [$this->cost_center => 100];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}