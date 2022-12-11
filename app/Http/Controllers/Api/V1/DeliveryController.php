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
        $shipping = Shipping::where('status', 'To Ship')
            ->where('vehicle_id', $vehicle->id)
            ->get();

        return response([
            'deliveries' => $shipping,
        ], 200);
    }

    public function show(Shipping $shipping) {
        return response([
            'delivery' => $shipping,
        ], 200);
    }

    public function updateCurrentMap(
        Request $request,
        Shipping $shipping
    ){
        $shipping->update([
            'current_location_latitude' => $request->current_location_latitude,
            'current_location_longtitude' => $request->current_location_longtitude,
        ]);

        return response([
            'message' => 'Delivery updated.',
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
