<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @method static Model updateOrCreate(array $attributes, array $values)
 *
 * @package App\Models
 */
class Order extends Model
{
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['product_no', 'order_no'];
}
