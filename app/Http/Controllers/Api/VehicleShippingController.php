<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use App\Shipping;
use App\ShippingItem;
use Illuminate\Support\Str;

class VehicleShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Vehicle $vehicle) {
        return [
            'status' => 'success',
            'message' => 'Get all vehicle delivery list successful.', 
            'data' => $vehicle->shippings,
        ];
    }

    public function create(
        Vehicle $vehicle,
        Request $request
    ) {
        $new_shipping = $vehicle->shippings()->create([
            'receiver' => $request->receiver,
            'contact_number' => $request->contact_number,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'status' => $request->status,
        ]);

        foreach ($request->items as $item) {
            ShippingItem::create([
                'ref' => Str::random(15),
                'product_id' => $item['id'],
                'shipping_id' => $new_shipping->id,
                'quantity' => $item['item_quantity'],
                'price' => $item['retail_price'],
                'total' => $item['total'],
            ]);
        }
        
        return [
            'status' => 'success',
            'message' => 'Added Delivery successful.',
        ];
    }

    public function edit(
        Shipping $shipping,
        Request $request
    ) {
        $update_shipping = $shipping->update($request->all());

        if ($update_shipping) {
            return [
                'status' => 'success',
                'message' => 'Updated Delivery successful.',
            ];
        }
    }
}
