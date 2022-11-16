<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use App\Inventory;
use App\Shipping;
use App\User;

class ViewAllController extends Controller
{
    public function view() {
        return [
            'inventory_count' => Inventory::get()->count(),
            'vehicle_count' => Vehicle::get()->count(),
            'shipping_count' => Shipping::whereStatus('To Ship')
                            ->get()
                            ->count(),
            'user_count' => User::get()->count(),
        ];
    }
}
