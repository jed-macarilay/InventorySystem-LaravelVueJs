<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $table = 'vehicles';

    protected $fillable = [
        'vehicle_type',
        'plate_no',
        'user_id',
    ];

    public function shippings() {
        return $this->hasMany('App\Shipping')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
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
