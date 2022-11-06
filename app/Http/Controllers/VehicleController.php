<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
