<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

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
        return $this->belongsToMany('App\Inventory', 'order_details', 'order_id', 'inventory_id')->withPivot('quantity', 'total');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('l jS F Y, h:i A');
    }
}
