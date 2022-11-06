<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return [
            'status' => 'success',
            'message' => 'Get all vehicle list successful.', 
            'data' => Vehicle::all(),
        ];
    }

    public function store(Request $request)
    {
        $new_vehicle = Vehicle::create($request->all());

        return [
            'status' => 'success',
            'message' => 'Added new vehicle successful.',
        ];
    }
}
