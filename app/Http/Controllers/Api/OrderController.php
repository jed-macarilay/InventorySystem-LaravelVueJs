<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;
use App\Order;
use App\OrderDetail;

class OrderController extends Controller
{
    public function index(Shipping $shipping) {
        $order = Order::find($shipping->order->id);
        
        return [
            'status' => 'success',
            'message' => 'Get all Orders successful.', 
            'data' => $order->products,
        ];
    }
}
