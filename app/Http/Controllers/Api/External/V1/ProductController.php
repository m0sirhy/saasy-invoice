<?php

namespace App\Http\Controllers\Api\External\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product);
    }

    public function getAll(Request $request)
    {
        $products = Product::limit(5)->get();
        return response()->json($products);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json('Product deleted');
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }
}
