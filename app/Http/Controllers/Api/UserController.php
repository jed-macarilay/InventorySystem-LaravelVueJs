<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function add_user(Request $request) {
        if (auth()->user()->user_type !== 'admin') {
            return abort(404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'user_type' => 'required',
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->name,
        ]);
                
        return [
            'status' => 'success',
            'message' => 'Added user successful.',
        ];
    }

    public function showDrivers() {
        return [
            'status' => 'success',
            'message' => 'Get all drivers successful.',
            'data' => User::whereUserType('Driver')
                ->orderBy('created_at', 'desc')
                ->get(),
        ];
    }

    public function user() {
        if (auth()->user()->user_type !== 'admin') {
            return abort(404);
        }
        
        return [
            'status' => 'success',
            'message' => 'Get all users successful.', 
            'data' => User::latest()->get(),
        ];
    }

    public function changePassword(
        Request $request,
        User $user
    ) {
        
        if ($user->id === auth()->user()->id) {
            if(Hash::check($request->password, $user->password)) {
                $user->update([
                    'password' => $request->new_password,
                ]);

                return [
                    'status' => 'successful',
                    'message' => 'Change password is successful!',
                ];
            }
        } 

        return abort(404);
    }
}
