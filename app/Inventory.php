<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use DateTimeInterface;

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
        'category_id',
    ];

    function shippings() {
        return $this->belongsToMany('App\Shipping');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order')->withPivot('quantity', 'total');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
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
