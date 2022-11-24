<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'shipping_id',
        'order_date',
    ];

    public function shipping()
    {
        return $this->hasOne('App\Shipping');
    }

    public function products()
    {
        return $this->belongsToMany('App\Inventory', 'order_details', 'order_id', 'inventory_id');
    }
}
