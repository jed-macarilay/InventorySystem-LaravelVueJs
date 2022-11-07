<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use App\Shpping;

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
            'data' => Vehicle::find($vehicle->id)->shippings,
        ];
    }
}
