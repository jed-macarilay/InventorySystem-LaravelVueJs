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
        'address',
        'status',
        'vehicle_id',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class)->latest();
    }

    protected $casts = [
        'updated_at' => 'datetime:l jS F Y, h:i:s A',
    ];
}
