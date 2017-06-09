<?php

namespace app\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol_left
 * @property string $symbol_right
 * @property integer $decimal_places
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 * @property \DateTime $deleted_at
 */
class Currency extends BaseTable
{
    use SoftDeletes;

    protected $guarded = ['id'];

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'code' => 'required'
    ];
}