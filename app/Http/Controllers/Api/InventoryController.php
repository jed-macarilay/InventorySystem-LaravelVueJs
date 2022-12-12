<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\Notification;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return [
            'status' => 'success',
            'message' => 'Get all product list successful.', 
            'data' => Inventory::with('category')
                ->orderBy('created_at', 'DESC')
                ->get(),
        ];
    }

    public function create(Request $request) {
        $new_product = Inventory::create($request->all());

        if ($request->quantity < 1) {
            Notification::create(['data' => 'Product ID# '.$new_product->id.' stock is empty']);
        }

        return [
            'status' => 'success',
            'message' => 'Added new product successful.',
        ];
    }

    public function edit(
        Request $request, 
        Inventory $inventory
    ) {
        $inventory->product_name = $request->product_name;
        $inventory->serial_code = $request->serial_code;
        $inventory->description = $request->description;
        $inventory->last_quantity = $inventory->quantity;
        $inventory->quantity = $request->quantity;
        $inventory->retail_price = $request->retail_price;
        $inventory->category_id = $request->category_id;

        if ($request->quantity <= 50) {
            Notification::create(['data' => 'Product - '.$new_product->product_name.' is in Critial Level.']);
        }
        
        if ($inventory->save()) {
            return [
                'status' => 'success',
                'message' => 'Update existed product successful.',
            ];
        }
    }

    public function destroy(Inventory $inventory) {
        if ($inventory->delete()) {
            return [
                'status' => 'success',
                'message' => 'Deleted successful.',
            ];
        }
    }
}
