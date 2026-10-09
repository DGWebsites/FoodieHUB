<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_available', true)
            ->latest()
            ->get();

        return view('home.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_available, 404);

        $product->load('category');

        return view('products.show', compact('product'));
    }
}