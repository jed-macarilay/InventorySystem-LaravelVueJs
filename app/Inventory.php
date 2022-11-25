<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';
    
    protected $fillable = [
        'product_name',
        'serial_code',
        'description',
        'retail_price',
        'quantity',
    ];

    function shippings() {
        return $this->belongsToMany('App\Shipping');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order')->withPivot('quantity', 'total');
    }

    protected $casts = [
        'updated_at' => 'datetime:l jS F Y, h:i A',
    ];
}
