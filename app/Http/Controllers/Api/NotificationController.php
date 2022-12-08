<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{
    public function index() {
        return response([
            'message' => 'successful get notification',
            'data' => Notification::orderBy('created_at', 'DESC')
                ->get(),
        ], 200);
    }
} 
