<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Shipping extends Model
{
    use SoftDeletes;

    protected $table = 'shippings';

    protected $fillable = [
        'receiver',
        'contact_number',
        'origin',
        'origin_latitude',
        'origin_longtitude',
        'destination',
        'destination_latitude',
        'destination_longtitude',
        'status',
        'vehicle_id',
        'current_location',
    ];

    public function vehicle() {
        return $this->belongsTo('App\Vehicle', 'id')->latest();
    }

    public function order()
    {
        return $this->hasOne('App\Order');
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
