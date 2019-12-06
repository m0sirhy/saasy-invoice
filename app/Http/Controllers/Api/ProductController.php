<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function getAll(Request $request)
    {
    	$products = Product::all();
    	return response()->json($products);
    }
}
