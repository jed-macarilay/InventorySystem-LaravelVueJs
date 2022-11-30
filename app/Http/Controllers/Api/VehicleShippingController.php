<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use App\Shipping;
use App\Inventory;
use App\Order;
use App\OrderDetail;
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
            'origin_latitude' => $request->origin_latitude,
            'origin_longtitude' => $request->origin_longtitude,
            'destination' => $request->destination,
            'destination_latitude' => $request->destination_latitude,
            'destination_longtitude' => $request->destination_longtitude,
            'current_location' => $request->current_location,
            'current_location_latitude' => $request->current_location_latitude,
            'current_location_longtitude' => $request->current_location_longtitude,
            'status' => $request->status,
        ]);

        $order = Order::create([
            'shipping_id' => $new_shipping->id,
            'order_date' => now(),
        ]);

        foreach ($request->items as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'inventory_id' => $item['id'],
                'quantity' => $item['item_quantity'],
                'total' => $item['total'],
            ]);

            $product = Inventory::find($item['id']);
            $product->last_quantity = $product->quantity;
            $product->quantity = $product->quantity - $item['item_quantity'];
            $product->save();
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
