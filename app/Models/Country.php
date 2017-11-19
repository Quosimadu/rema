<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;


/**
 * Class Country
 * @package app\Models
 *
 * @property int $id
 * @property string $iso_code_2
 * @property string $iso_code_3
 * @property string $iso_number
 * @property string $name
 * @property int|null $currency_id
 * @property int|null $phone_code
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 * @property \DateTime $deleted_at
 */
class Country extends BaseTable
{
    use SoftDeletes;
    use Eloquence;

    protected $guarded = ['id'];

    protected $searchableColumns = ['is_code_2', 'is_code_3', 'name'];

    public function currency()
    {

        return $this->belongsTo('Currency');
    }

}