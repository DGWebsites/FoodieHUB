@extends('layouts.app')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Order Status Progress
    |--------------------------------------------------------------------------
    */

    $statusSteps = [
        'Pending',
        'Confirmed',
        'Preparing',
        'Ready',
        'Out for Delivery',
        'Delivered',
        'Completed',
    ];

    $currentStatusIndex = array_search(
        $order->status,
        $statusSteps
    );

    if ($currentStatusIndex === false) {
        $currentStatusIndex = -1;
    }

    $isCancelled = in_array(
        $order->status,
        ['Cancelled', 'Rejected']
    );

@endphp


<section class="order-details-section">

    <div class="container">

        <a
            href="{{ route('orders.index') }}"
            class="back-orders"
        >
            ← Back to My Orders
        </a>


        @if(session('success'))

            <div class="order-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- =====================================================
             ORDER HEADER
        ====================================================== --}}

        <div class="order-details-heading">

            <div>

                <span class="section-label">
                    ORDER DETAILS
                </span>

                <h1>
                    Order #{{ $order->id }}
                </h1>

                <p>
                    Placed on
                    {{ $order->created_at->format(
                        'F d, Y h:i A'
                    ) }}
                </p>

            </div>


            <span
                class="order-status
                status-{{ strtolower(
                    str_replace(
                        ' ',
                        '-',
                        $order->status
                    )
                ) }}"
            >
                {{ $order->status }}
            </span>

        </div>


        {{-- =====================================================
             ORDER TRACKING
        ====================================================== --}}

        <div class="tracking-card">

            <div class="tracking-header">

                <div>

                    <span class="section-label">
                        ORDER TRACKING
                    </span>

                    <h2>
                        Track Your Order
                    </h2>

                    <p>
                        Follow the progress of your order here.
                    </p>

                </div>

            </div>


            @if($isCancelled)

                <div class="tracking-cancelled">

                    <div class="tracking-cancelled-icon">
                        ✕
                    </div>

                    <div>

                        <h3>
                            Order {{ $order->status }}
                        </h3>

                        <p>
                            This order is no longer being processed.
                        </p>

                    </div>

                </div>

            @else

                <div class="tracking-progress">

                    @foreach($statusSteps as $index => $step)

                        @php

                            $stepCompleted =
                                $currentStatusIndex >= $index;

                            $stepCurrent =
                                $currentStatusIndex === $index;

                            $stepClass =
                                $stepCompleted
                                    ? 'completed'
                                    : '';

                            if ($stepCurrent) {
                                $stepClass .= ' current';
                            }

                        @endphp


                        <div class="tracking-step {{ $stepClass }}">

                            <div class="tracking-step-indicator">

                                @if($stepCompleted)

                                    ✓

                                @else

                                    {{ $index + 1 }}

                                @endif

                            </div>


                            <div class="tracking-step-content">

                                <strong>
                                    {{ $step }}
                                </strong>


                                @if($stepCurrent)

                                    <span>
                                        Current status
                                    </span>

                                @elseif($stepCompleted)

                                    <span>
                                        Completed
                                    </span>

                                @else

                                    <span>
                                        Waiting
                                    </span>

                                @endif

                            </div>

                        </div>


                        @if($index < count($statusSteps) - 1)

                            <div
                                class="tracking-line
                                {{ $currentStatusIndex > $index
                                    ? 'completed'
                                    : '' }}"
                            ></div>

                        @endif

                    @endforeach

                </div>

            @endif

        </div>


        {{-- =====================================================
             ORDER DETAILS GRID
        ====================================================== --}}

        <div class="order-details-grid">


            {{-- =================================================
                 ORDER ITEMS
            ================================================== --}}

            <div class="order-details-card">

                <div class="details-card-header">

                    <div class="details-icon">
                        🍽️
                    </div>

                    <div>

                        <h2>
                            Your Items
                        </h2>

                        <p>
                            Items included in this order.
                        </p>

                    </div>

                </div>


                <div class="order-items-list">

                    @foreach($order->orderItems as $item)

                        <div class="order-detail-item">

                            <div class="order-detail-item-image">

                                @if($item->product->image)

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $item->product->image
                                        ) }}"
                                        alt="{{ $item->product->name }}"
                                    >

                                @else

                                    🍽️

                                @endif

                            </div>


                            <div class="order-detail-item-info">

                                <h3>
                                    {{ $item->product->name }}
                                </h3>

                                <p>
                                    {{ $item->quantity }}
                                    ×
                                    ₱{{ number_format(
                                        $item->unit_price,
                                        2
                                    ) }}
                                </p>

                            </div>


                            <strong>
                                ₱{{ number_format(
                                    $item->subtotal,
                                    2
                                ) }}
                            </strong>

                        </div>

                    @endforeach

                </div>


                {{-- Price Summary --}}

                <div class="order-price-summary">

                    <div>

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            ₱{{ number_format(
                                $order->subtotal,
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
                                $order->delivery_fee,
                                2
                            ) }}
                        </strong>

                    </div>


                    <div class="order-grand-total">

                        <span>
                            Total
                        </span>

                        <strong>
                            ₱{{ number_format(
                                $order->total,
                                2
                            ) }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 DELIVERY + PAYMENT
            ================================================== --}}

            <div>


                {{-- Delivery Information --}}

                <div class="order-details-card">

                    <div class="details-card-header">

                        <div class="details-icon">
                            📦
                        </div>

                        <div>

                            <h2>
                                Delivery Information
                            </h2>

                            <p>
                                Where your order will be delivered.
                            </p>

                        </div>

                    </div>


                    <div class="delivery-details">

                        <div>

                            <span>
                                Full Name
                            </span>

                            <strong>
                                {{ $order->full_name }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Phone
                            </span>

                            <strong>
                                {{ $order->phone }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Complete Address
                            </span>

                            <strong>
                                {{ $order->address }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Barangay
                            </span>

                            <strong>
                                {{ $order->barangay }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                City / Municipality
                            </span>

                            <strong>
                                {{ $order->city }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Postal Code
                            </span>

                            <strong>
                                {{ $order->postal_code }}
                            </strong>

                        </div>


                        @if($order->delivery_notes)

                            <div>

                                <span>
                                    Delivery Notes
                                </span>

                                <strong>
                                    {{ $order->delivery_notes }}
                                </strong>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Payment Information --}}

                <div class="order-details-card">

                    <div class="details-card-header">

                        <div class="details-icon">
                            💳
                        </div>

                        <div>

                            <h2>
                                Payment
                            </h2>

                            <p>
                                Payment information for this order.
                            </p>

                        </div>

                    </div>


                    <div class="payment-detail-row">

                        <span>
                            Payment Method
                        </span>

                        <strong>
                            {{ $order->payment_method }}
                        </strong>

                    </div>


                    <div class="payment-detail-row">

                        <span>
                            Payment Status
                        </span>

                        <strong>
                            {{ $order->payment_status }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection