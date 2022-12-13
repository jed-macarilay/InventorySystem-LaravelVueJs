<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        return view('pages.dashboard.index');
    }

    public function create() {
        if (auth()->user()->user_type !== 'admin') {
            return abort(404);
        }
        
        return view('pages.users.create');
    }

    public function changePassword() {
        if (auth()->user()->user_type !== 'admin') {
            return abort(404);
        }
        
        return view('pages.users.change_password');
    }
}
