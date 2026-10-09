<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Menu List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view(
            'admin.menu.index',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Add Menu Item Page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'admin.menu.create',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store New Menu Item
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        $imagePath = null;


        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }


        Product::create([
            'category_id' => $validated['category_id'],

            'name' => $validated['name'],

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'],

            'image' => $imagePath,

            'is_available' => $request->boolean(
                'is_available'
            ),
        ]);


        return redirect()
            ->route('admin.menu.index')
            ->with(
                'success',
                'Menu item added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Menu Item Page
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'admin.menu.edit',
            compact(
                'product',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Menu Item
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Keep Existing Image
        |--------------------------------------------------------------------------
        */

        $imagePath = $product->image;


        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');


            if ($product->image) {

                Storage::disk('public')
                    ->delete($product->image);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([
            'category_id' => $validated['category_id'],

            'name' => $validated['name'],

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'],

            'image' => $imagePath,

            'is_available' => $request->boolean(
                'is_available'
            ),
        ]);


        return redirect()
            ->route('admin.menu.index')
            ->with(
                'success',
                $product->name .
                ' was updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Menu Item
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | AVAILABLE ITEMS CANNOT BE DELETED
        |--------------------------------------------------------------------------
        */

        if ($product->is_available) {

            return redirect()
                ->route('admin.menu.index')
                ->with(
                    'error',
                    'This menu item is still available. Set it to unavailable first before deleting it.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Protect Order History
        |--------------------------------------------------------------------------
        */

        if ($product->orderItems()->exists()) {

            return redirect()
                ->route('admin.menu.index')
                ->with(
                    'error',
                    'This menu item is unavailable, but it cannot be deleted because it has already been used in an order. Keeping it preserves your order history.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if ($product->image) {

            Storage::disk('public')
                ->delete($product->image);
        }


        $productName = $product->name;


        /*
        |--------------------------------------------------------------------------
        | Delete Product
        |--------------------------------------------------------------------------
        */

        $product->delete();


        return redirect()
            ->route('admin.menu.index')
            ->with(
                'success',
                $productName .
                ' was deleted successfully.'
            );
    }
}