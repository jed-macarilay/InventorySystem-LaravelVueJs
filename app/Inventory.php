<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';
    
    protected $fillable = [
        'product_name',
        'serial_code',
        'quantity',
    ];
}
