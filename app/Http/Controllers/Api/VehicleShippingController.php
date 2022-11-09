<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use App\Shipping;

class VehicleShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Vehicle $vehicle) {
        return [
            'status' => 'success',
            'message' => 'Get all vehicle shippings successful.', 
            'data' => $vehicle->shippings,
        ];
    }

    public function create(
        Vehicle $vehicle,
        Request $request
    ) {
        $new_shipping = $vehicle->shippings()->create($request->all());

        if ($new_shipping) {
            return [
                'status' => 'success',
                'message' => 'Added Shipping in Vehicle is successful.',
            ];
        }
    }

    public function edit(
        Shipping $shipping,
        Request $request
    ) {
        $update_shipping = $shipping->update($request->all());

        if ($update_shipping) {
            return [
                'status' => 'success',
                'message' => 'Updated Shipping in Vehicle is successful.',
            ];
        }
    }
}
