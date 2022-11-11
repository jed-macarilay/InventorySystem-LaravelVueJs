<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;

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
            'data' => Inventory::all(),
        ];
    }

    public function create(Request $request) {
        $new_product = Inventory::create($request->all());

        return [
            'status' => 'success',
            'message' => 'Added new vehicle successful.',
        ];
    }

    public function edit(
        Request $request, 
        Inventory $inventory
    ) {
        if ($inventory->update($request->all())) {
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
