<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Shipping;

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

    public function create(Vehicle $vehicle) {
        $data['vehicle'] = $vehicle;
        return view('pages.shippings.create', $data);
    }

    public function createShipping() {
        return view('pages.order.create');
    }

    public function edit(Shipping $shipping) {
        return view('pages.shippings.edit', [
            'shipping' => $shipping,
        ]);
    }
    
    public function map(Shipping $shipping) {
        return view('pages.shippings.map', [
            'shipping' => $shipping,
            'driver' => $shipping->vehicle->user->name,
        ]);
    }
}
