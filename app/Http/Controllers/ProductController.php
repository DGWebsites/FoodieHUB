<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $query = Product::with('category')
            ->where('is_available', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->string('search')->trim();

            $query->where(function ($productQuery) use ($search) {
                $productQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($categoryQuery) use ($request) {
                $categoryQuery->where('id', $request->integer('category'));
            });
        }

        $products = $query
            ->latest()
            ->get();

        return view('home.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_available, 404);

        $product->load('category');

        return view('products.show', compact('product'));
    }
}