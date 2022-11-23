<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingItem extends Model
{
    protected $table = 'shipping_item';

    protected $fillable = [
        'ref',
        'quantity',
        'price',
        'total',
        'product_id',
        'shipping_id',
    ];
}
