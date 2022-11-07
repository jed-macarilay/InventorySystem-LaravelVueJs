<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $table = 'vehicles';

    protected $fillable = [
        'plate_no',
        'driver',
    ];

    public function shippings() {
        return $this->hasMany(Shipping::class);
    }
}
