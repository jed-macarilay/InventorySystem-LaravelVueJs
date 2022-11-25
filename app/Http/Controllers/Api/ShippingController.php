<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;

class ShippingController extends Controller
{
    public function index(Shipping $shipping) {
        return [
            'status' => 'success',
            'message' => 'Get all Sales successful.', 
            'data' => Shipping::with('vehicle')
                ->get(),
        ];
    }
}
