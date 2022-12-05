<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $attrs = $request->validate([
            'email'  =>  'required|email',
            'password'  =>  'required|min:6',
        ]);

        if(!Auth::attempt([
            'email' => $attrs['email'],
            'password' => $attrs['password'],
            'user_type' => 'Driver',
        ])) {
            return response([
                'message' => 'Invalid credentials.',
            ], 403);
        }

        return response([
            'user' => auth()->user(),
            'token' => auth()
                ->user()
                ->createToken('secret')
                ->plainTextToken,
        ], 200);
    }

    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

    public function logout() {
        auth()
            ->user()
            ->tokens()
            ->delete();

        return response([
            'message' => 'Logout Success',
        ], 200);
    }
}
