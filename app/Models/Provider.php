<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;

/**
 * service providers
 * @package App\Models
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile
 * @property string $comment
 * @property string $address *
 * @property int $created_by
 * @property int $changed_by
 * @property \DateTime $created_at
 * @property \DateTime $changed_at
 * @property \DateTime $deleted_at
 */
class Provider extends BaseTable
{
    use SoftDeletes;
    use Eloquence;

    protected $fillable = ['first_name','last_name','email','mobile', 'comment','address'];

    protected $dates = ['deleted_at'];

    protected $searchableColumns = ['first_name', 'last_name', 'mobile'];


}
