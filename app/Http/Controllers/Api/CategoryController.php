<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index() {
        return response([
            'status' => 'success',
            'message' => 'Get all Category successful.',
            'data' => Category::all(),
        ], 200);
    }

    public function show() {
        $category = Category::with('products')
            ->withCount('products')
            ->get();
        return response([
            'status' => 'success',
            'Get all Category for Chart',
            'data' => $category,
        ], 200);
    }

    public function create(Request $request) {
        $category = Category::create([
            'category' => $request->category,
        ]);

        if ($category) {
            return response([
                'status' => 'success',
                'message' => 'Added Category Successful',
            ], 200);
        }
    }
}
