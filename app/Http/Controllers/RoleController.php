<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        return view('pages.roles.index');
    }

    public function create() {
        return view('pages.roles.create');
    }
}
