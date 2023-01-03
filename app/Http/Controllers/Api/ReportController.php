<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;

class ReportController extends Controller
{
    public function index(Request $request) {
        return response([
            'status' => 'success',
            'message' => 'Get all Sales successful.', 
            'data' => Shipping::with('vehicle')
                ->whereBetween('created_at', [
                    $request->start_date,
                    $request->end_date
                ])
                ->get(),
        ]);
    }
}
