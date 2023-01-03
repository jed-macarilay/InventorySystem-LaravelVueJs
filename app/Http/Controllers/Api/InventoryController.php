<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\Notification;
use Illuminate\Support\Str;

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

    public function getItems() {
        return response([
            'status' => 'success',
            'message' => 'Get all product list successful.', 
            'data' => Inventory::with('category')
                ->where('quantity', '>', 0)
                ->where('unit_price', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->get(),
        ]);
    }

    public function create(Request $request) {
        $product = new Inventory;
        $product->product_name = $request->product_name;
        $product->SKU = Str::random(12);
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->last_quantity = $request->last_quantity;
        $product->unit_price = $request->unit_price;
        $product->category_id = $request->category_id;

        if ($product->save()) {
            if ($product->quantity <= 50) {
                Notification::create(['data' => 'Product - '.$product->product_name.' is in Critial Level.']);
            }

            return [
                'status' => 'success',
                'message' => 'Added new product successful.',
            ];
        }
    }

    public function edit(
        Request $request, 
        Inventory $inventory
    ) {
        $inventory->product_name = $request->product_name;
        $inventory->description = $request->description;
        $inventory->last_quantity = $inventory->quantity;
        $inventory->quantity = $request->quantity;
        $inventory->unit_price = $request->unit_price;
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
