<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TimeLog
 * @package App\Models
 * @property int $id
 * @property int $listing_id
 * @property int $user_id
 * @property string $start
 * @property string $end
 * @property string $comment
 * @property int $is_paid
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 * @property \DateTime $deleted_at
 */
class TimeLog extends BaseTable
{
    use SoftDeletes;

    protected $table = 'time_logs';

    protected $fillable = ['listing_id','user_id','start','end',
        'comment','is_paid'];

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public static $rules = [
        'listing_id' => 'required',
        'start_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required'
    ];


    public function listing()
    {
        return $this->belongsTo('App\Models\Listing', 'listing_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}