<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function index() {
        return response([
            'message' => 'Get all roles successful.',
            'data' => Role::latest()->get(),
        ], 200);
    }

    public function create(Request $request) {
        $role = Role::create([
            'role' => $request->role,
        ]);

        if($role) {
            return response([
                'message' => 'Added role is successful.',
            ], 200);
        }
    }
}
