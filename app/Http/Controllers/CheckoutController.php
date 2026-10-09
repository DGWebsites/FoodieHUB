<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        // Prevent checkout when the cart is empty.
        if (empty($cart)) {
            return redirect()
                ->route('home')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate the display subtotal.
        $subtotal = collect($cart)->sum(function ($item) {
            return (float) $item['price'] * (int) $item['quantity'];
        });

        // Temporary fixed delivery fee.
        $deliveryFee = 50.00;

        $total = $subtotal + $deliveryFee;

        return view('checkout.index', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $total,
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $cart = session()->get('cart', []);

        // Prevent empty-cart orders.
        if (empty($cart)) {
            return redirect()
                ->route('home')
                ->with('error', 'Your cart is empty.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get the latest product information from the database
        |--------------------------------------------------------------------------
        |
        | We do NOT trust the prices stored in the session cart.
        | The database is the source of truth.
        |
        */

        $productIds = array_map(
            'intval',
            array_keys($cart)
        );

        $products = Product::whereIn('id', $productIds)
            ->where('is_available', true)
            ->get()
            ->keyBy('id');

        // Make sure every cart item still exists and is available.
        foreach ($productIds as $productId) {

            if (!$products->has($productId)) {
                return redirect()
                    ->route('home')
                    ->with(
                        'error',
                        'One or more products in your cart are no longer available.'
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create Order
        |--------------------------------------------------------------------------
        */

        $deliveryFee = 50.00;

        $subtotal = 0;

        foreach ($cart as $item) {

            $productId = (int) $item['id'];

            $quantity = max(
                1,
                (int) $item['quantity']
            );

            $product = $products->get($productId);

            $subtotal +=
                (float) $product->price *
                $quantity;
        }

        $total = $subtotal + $deliveryFee;

        /*
        |--------------------------------------------------------------------------
        | Save everything in one database transaction
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use (
            $request,
            $cart,
            $products,
            $subtotal,
            $deliveryFee,
            $total
        ) {

            $order = Order::create([

                'user_id' => Auth::id(),

                // Delivery information
                'full_name' => $request->validated('full_name'),
                'phone' => $request->validated('phone'),
                'address' => $request->validated('address'),
                'barangay' => $request->validated('barangay'),
                'city' => $request->validated('city'),
                'postal_code' => $request->validated('postal_code'),
                'delivery_notes' => $request->validated(
                    'delivery_notes'
                ),

                // Totals
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,

                // Payment
                'payment_method' => $request->validated(
                    'payment_method'
                ),
                'payment_status' => 'Pending',

                // Order status
                'status' => 'Pending',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Save Order Items
            |--------------------------------------------------------------------------
            */

            foreach ($cart as $item) {

                $productId = (int) $item['id'];

                $quantity = max(
                    1,
                    (int) $item['quantity']
                );

                $product = $products->get($productId);

                $unitPrice = (float) $product->price;

                $itemSubtotal =
                    $unitPrice * $quantity;


                $order->orderItems()->create([

                    'product_id' => $product->id,

                    'quantity' => $quantity,

                    'unit_price' => $unitPrice,

                    'subtotal' => $itemSubtotal,

                ]);
            }


            return $order;
        });


        /*
        |--------------------------------------------------------------------------
        | Clear the cart after successful order creation
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');


        /*
        |--------------------------------------------------------------------------
        | Send customer to their order
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('orders.show', $order)
            ->with(
                'success',
                'Your order has been placed successfully!'
            );
    }
}