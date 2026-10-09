@extends('layouts.app')

@section('content')

<section class="checkout-section">

    <div class="container">

        <div class="checkout-heading">

            <span class="section-label">
                CHECKOUT
            </span>

            <h1>
                Complete Your Order
            </h1>

            <p>
                Enter your delivery information and choose your payment method.
            </p>

        </div>


        @if(session('error'))

            <div class="checkout-alert">
                {{ session('error') }}
            </div>

        @endif


        <div class="checkout-grid">


            {{-- =====================================================
                 DELIVERY INFORMATION
            ====================================================== --}}

            <div class="checkout-card">

                <div class="checkout-card-header">

                    <div class="checkout-card-icon">
                        📦
                    </div>

                    <div>

                        <h2>
                            Delivery Information
                        </h2>

                        <p>
                            Where should we deliver your order?
                        </p>

                    </div>

                </div>


                @if($errors->any())

                    <div class="auth-error">

                        <strong>
                            Please check the following:
                        </strong>

                        <ul>

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('checkout.store') }}"
                    class="checkout-form"
                >

                    @csrf


                    <div class="form-group">

                        <label for="full_name">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            value="{{ old(
                                'full_name',
                                auth()->user()->name
                            ) }}"
                            placeholder="Enter your full name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="phone">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="09XXXXXXXXX"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="address">
                            Complete Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            placeholder="House number, street, subdivision, etc."
                            required
                        >{{ old('address') }}</textarea>

                    </div>


                    <div class="checkout-form-row">

                        <div class="form-group">

                            <label for="barangay">
                                Barangay
                            </label>

                            <input
                                type="text"
                                id="barangay"
                                name="barangay"
                                value="{{ old('barangay') }}"
                                placeholder="Barangay"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label for="city">
                                City / Municipality
                            </label>

                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="City / Municipality"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="postal_code">
                            Postal Code
                        </label>

                        <input
                            type="text"
                            id="postal_code"
                            name="postal_code"
                            value="{{ old('postal_code') }}"
                            placeholder="Postal code"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="delivery_notes">
                            Delivery Notes
                            <span class="optional">
                                Optional
                            </span>
                        </label>

                        <textarea
                            id="delivery_notes"
                            name="delivery_notes"
                            rows="3"
                            placeholder="Gate color, landmarks, special instructions..."
                        >{{ old('delivery_notes') }}</textarea>

                    </div>


                    {{-- =================================================
                         PAYMENT
                    ================================================== --}}

                    <div class="payment-section">

                        <div class="checkout-card-header small">

                            <div class="checkout-card-icon">
                                💳
                            </div>

                            <div>

                                <h2>
                                    Payment Method
                                </h2>

                                <p>
                                    Choose how you want to pay.
                                </p>

                            </div>

                        </div>


                        <div class="payment-options">


                            <label class="payment-option">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="Cash on Delivery"
                                    {{ old(
                                        'payment_method'
                                    ) === 'Cash on Delivery'
                                        ? 'checked'
                                        : '' }}
                                    required
                                >

                                <span class="payment-option-content">

                                    <span class="payment-icon">
                                        💵
                                    </span>

                                    <span>

                                        <strong>
                                            Cash on Delivery
                                        </strong>

                                        <small>
                                            Pay when your order arrives.
                                        </small>

                                    </span>

                                </span>

                            </label>


                            <label class="payment-option">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="GCash"
                                    {{ old(
                                        'payment_method'
                                    ) === 'GCash'
                                        ? 'checked'
                                        : '' }}
                                >

                                <span class="payment-option-content">

                                    <span class="payment-icon">
                                        📱
                                    </span>

                                    <span>

                                        <strong>
                                            GCash
                                        </strong>

                                        <small>
                                            GCash payment will be processed later.
                                        </small>

                                    </span>

                                </span>

                            </label>


                        </div>

                    </div>


                    <button
                        type="submit"
                        class="place-order-button"
                    >

                        <span>
                            Confirm Order
                        </span>

                        <span>
                            →
                        </span>

                    </button>

                </form>

            </div>


            {{-- =====================================================
                 ORDER SUMMARY
            ====================================================== --}}

            <aside class="checkout-summary">

                <div class="checkout-summary-header">

                    <div>

                        <span class="section-label">
                            YOUR ORDER
                        </span>

                        <h2>
                            Order Summary
                        </h2>

                    </div>

                </div>


                <div class="checkout-items">

                    @foreach($cart as $item)

                        <div class="checkout-item">

                            <div class="checkout-item-image">
                                🍽️
                            </div>

                            <div class="checkout-item-info">

                                <h3>
                                    {{ $item['name'] }}
                                </h3>

                                <p>
                                    {{ $item['quantity'] }}
                                    ×
                                    ₱{{ number_format(
                                        $item['price'],
                                        2
                                    ) }}
                                </p>

                            </div>


                            <strong>

                                ₱{{ number_format(
                                    $item['price'] *
                                    $item['quantity'],
                                    2
                                ) }}

                            </strong>

                        </div>

                    @endforeach

                </div>


                <div class="checkout-totals">

                    <div>

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            ₱{{ number_format(
                                $subtotal,
                                2
                            ) }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Delivery Fee
                        </span>

                        <strong>
                            ₱{{ number_format(
                                $deliveryFee,
                                2
                            ) }}
                        </strong>

                    </div>


                    <div class="checkout-total">

                        <span>
                            Total
                        </span>

                        <strong>
                            ₱{{ number_format(
                                $total,
                                2
                            ) }}
                        </strong>

                    </div>

                </div>


                <a
                    href="{{ route('home') }}"
                    class="back-to-menu"
                >
                    ← Continue Shopping
                </a>

            </aside>


        </div>

    </div>

</section>

@endsection