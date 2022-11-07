<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Vehicle $vehicle) {
        $data['vehicle'] = $vehicle;
        return view('pages.shippings.index', $data);
    }
}
