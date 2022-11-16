<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(
            'email',
            'password',
        );

        if(auth()->attemot($credentials)) {
            return [
                'status' => 'success',
                'message' => 'Login successful.'
            ];
        }
    }

    public function add_user(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required',
        ]);
        
        $user = User::create(request([
            'name',
            'email',
            'password',
            'user_type',
        ]));
                
        return [
            'status' => 'success',
            'message' => 'Added user successful.',
        ];
    }

    public function user() {
        return [
            'status' => 'success',
            'message' => 'Get all users successful.', 
            'data' => User::all(),
        ];
    }
}
