<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Cart endpoint',
        ]);
    }

    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_available, 404);

        $quantity = max(1, $request->integer('quantity', 1));

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'category' => $product->category?->name,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => $product->name . ' added to cart.',
            'cart' => $cart,
            'count' => $this->cartCount($cart),
            'subtotal' => $this->cartSubtotal($cart),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $quantity = $request->integer('quantity');

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not in the cart.',
            ], 404);
        }

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'count' => $this->cartCount($cart),
            'subtotal' => $this->cartSubtotal($cart),
        ]);
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        unset($cart[$product->id]);

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'count' => $this->cartCount($cart),
            'subtotal' => $this->cartSubtotal($cart),
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'cart' => [],
            'count' => 0,
            'subtotal' => 0,
        ]);
    }

    public function data()
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'cart' => $cart,
            'count' => $this->cartCount($cart),
            'subtotal' => $this->cartSubtotal($cart),
        ]);
    }

    private function cartCount(array $cart): int
    {
        return array_sum(
            array_column($cart, 'quantity')
        );
    }

    private function cartSubtotal(array $cart): float
    {
        return array_reduce(
            $cart,
            fn (float $total, array $item) =>
                $total + ($item['price'] * $item['quantity']),
            0
        );
    }
}