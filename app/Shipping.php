<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use SoftDeletes;

    protected $table = 'shippings';

    protected $fillable = [
        'receiver',
        'contact_number',
        'origin',
        'destination',
        'status',
        'vehicle_id',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class)->latest();
    }

    public function order()
    {
        return $this->hasOne('App\Order');
    }

    protected $casts = [
        'created_at' => 'datetime:l jS F Y, h:i A',
        'updated_at' => 'datetime:l jS F Y, h:i A',
    ];
}
