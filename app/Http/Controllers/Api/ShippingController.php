<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Str;

class ShippingController extends Controller
{
    public function index(Shipping $shipping) {
        return [
            'status' => 'success',
            'message' => 'Get all Sales successful.', 
            'data' => Shipping::with('vehicle')
                ->get(),
        ];
    }

    public function create(Request $request) {
        $new_shipping = Shipping::create([
            'order_code' => Str::random(5),
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
            'vehicle_id' => $request->vehicle_id,
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

            if ($product->quantity < 1) {
                Notification::create(['data' => 'Product ID# '.$product->id.' stock is empty']);
            }
            
            $product->save();
        }
        
        return [
            'status' => 'success',
            'message' => 'Added Delivery successful.',
        ];
    }
}
