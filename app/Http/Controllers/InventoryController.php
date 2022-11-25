<?php

namespace App\Http\Controllers;

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
        return view('pages.inventory.index');
    }

    public function create() {
        return view('pages.inventory.create');
    }

    public function edit(Inventory $inventory) {
        return view('pages.inventory.edit', [
            'inventory' => $inventory,
        ]);
    }
}
