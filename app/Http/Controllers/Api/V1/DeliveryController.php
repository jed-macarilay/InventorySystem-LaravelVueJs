<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use App\Shipping;

class DeliveryController extends Controller
{
    public function index() {
        $vehicle = Vehicle::whereUserId(auth()->user()->id)->first();
        return response([
            'deliveries' => $vehicle->shippings->where('status', 'To Ship'),
        ], 200);
    }

    public function show(Shipping $shipping) {
        return response([
            'delivery' => $shipping,
        ], 200);
    }

    public function setStatus(
        Request $request,
        Shipping $shipping
    ){
        $attrs = $request->validate([
            'status' => 'required'
        ]);  

        $shipping->update([
            'status' => $request->status,
        ]);

        return response([
            'message' => 'Delivery updated.',
            'delivery' => $shipping,
        ], 200);
    } 
}
