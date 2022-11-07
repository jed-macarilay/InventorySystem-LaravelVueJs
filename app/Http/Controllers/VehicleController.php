<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('pages.vehicles.index');
    }

    public function create() {
        return view('pages.vehicles.create');
    }

    public function edit(Vehicle $vehicle) {
        $edit_vehicle = Vehicle::find($vehicle);

        $data['vehicle'] = $edit_vehicle;

        return view('pages.vehicles.edit', $data);
    }
}
