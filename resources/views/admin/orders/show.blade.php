@extends('layouts.app')

@section('content')

<section class="admin-order-details-section">

    <div class="container">

        <a
            href="{{ route('admin.orders.index') }}"
            class="back-orders"
        >
            ← Back to Orders
        </a>


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="order-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR MESSAGES --}}

        @if($errors->any())

            <div class="order-error">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- =====================================================
             ORDER HEADER
        ====================================================== --}}

        <div class="admin-order-details-header">

            <div>

                <span class="section-label">
                    ADMIN PANEL
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
             DRIVER ASSIGNMENT
        ====================================================== --}}

        <div class="admin-driver-card">

            <div class="admin-driver-card-header">

                <div class="details-icon">
                    🚚
                </div>

                <div>

                    <span class="section-label">
                        DELIVERY
                    </span>

                    <h2>
                        Assign Delivery Driver
                    </h2>

                    <p>
                        Choose a driver to handle this order.
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route(
                    'admin.orders.assign-driver',
                    $order
                ) }}"
                class="admin-driver-form"
            >

                @csrf

                @method('PATCH')


                <div class="admin-driver-select-group">

                    <label for="driver_id">
                        Delivery Driver
                    </label>

<select
    id="driver_id"
    name="driver_id"
>

    <option value="">
        No driver assigned
    </option>


    {{-- CURRENT INACTIVE DRIVER --}}

    @if(
        $currentDriver &&
        !$currentDriver->is_active
    )

        <option
            value="{{ $currentDriver->id }}"
            selected
            disabled
        >
            {{ $currentDriver->name }}
            — Inactive
        </option>

    @endif


    {{-- ACTIVE DRIVERS --}}

   @foreach($drivers as $driver)

    <option
        value="{{ $driver->id }}"
        {{ $order->driver_id === $driver->id
            ? 'selected'
            : '' }}
    >
        {{ $driver->name }}
        — {{ $driver->active_orders_count }}
        {{ $driver->active_orders_count === 1
            ? 'active delivery'
            : 'active deliveries' }}
    </option>

@endforeach

</select>

                </div>


             <div class="admin-current-driver">

    <span>
        Current Driver
    </span>


    <strong>

        @if($currentDriver)

            🚚 {{ $currentDriver->name }}

            @if($currentDriver->is_active)

                <small class="admin-current-driver-active">
                    🟢 Active
                </small>

            @else

                <small class="admin-current-driver-inactive">
                    ⚫ Inactive
                </small>

            @endif

        @else

            No driver assigned

        @endif

    </strong>

</div>


                <button
                    type="submit"
                    class="admin-assign-driver-button"
                >
                    Save Driver Assignment
                </button>

            </form>

        </div>


        {{-- =====================================================
             UPDATE STATUS
        ====================================================== --}}

        <div class="admin-status-card">

            <div class="admin-status-heading">

                <div>

                    <span class="section-label">
                        ORDER STATUS
                    </span>

                    <h2>
                        Update Order
                    </h2>

                    <p>
                        Change the order status as it moves through the process.
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route(
                    'admin.orders.update-status',
                    $order
                ) }}"
                class="admin-status-form"
            >

                @csrf

                @method('PATCH')


                <div class="admin-status-options">

                    <label>

                        <span>
                            Pending
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Pending"
                            {{ $order->status === 'Pending'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Confirmed
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Confirmed"
                            {{ $order->status === 'Confirmed'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Preparing
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Preparing"
                            {{ $order->status === 'Preparing'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Ready
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Ready"
                            {{ $order->status === 'Ready'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Out for Delivery
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Out for Delivery"
                            {{ $order->status === 'Out for Delivery'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Delivered
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Delivered"
                            {{ $order->status === 'Delivered'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Completed
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Completed"
                            {{ $order->status === 'Completed'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Cancelled
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Cancelled"
                            {{ $order->status === 'Cancelled'
                                ? 'checked'
                                : '' }}
                        >

                    </label>


                    <label>

                        <span>
                            Rejected
                        </span>

                        <input
                            type="radio"
                            name="status"
                            value="Rejected"
                            {{ $order->status === 'Rejected'
                                ? 'checked'
                                : '' }}
                        >

                    </label>

                </div>


                <button
                    type="submit"
                    class="admin-update-status-button"
                >
                    Update Status
                </button>

            </form>

        </div>


        {{-- =====================================================
             DRIVER CANCELLATION INFORMATION
        ====================================================== --}}

        @if($order->status === 'Cancelled')

            <div class="admin-cancellation-card">

                <div class="admin-cancellation-header">

                    <div class="admin-cancellation-icon">
                        ❌
                    </div>

                    <div>

                        <span>
                            DELIVERY CANCELLED
                        </span>

                        <h3>
                            This order was cancelled
                        </h3>

                    </div>

                </div>


                <div class="admin-cancellation-details">


                    {{-- CANCELLATION REASON --}}

                    <div class="admin-cancellation-detail">

                        <span>
                            Cancellation Reason
                        </span>

                        <strong>
                            {{ $order->cancellation_reason ?? 'No reason provided.' }}
                        </strong>

                    </div>


                    {{-- CANCELLED BY --}}

                    <div class="admin-cancellation-detail">

                        <span>
                            Cancelled By
                        </span>

                        <strong>
                            {{ $order->cancelled_by ?? 'Unknown' }}
                        </strong>

                    </div>


                    {{-- CANCELLED AT --}}

                    <div class="admin-cancellation-detail">

                        <span>
                            Cancelled At
                        </span>

                        <strong>

                          @if($order->cancelled_at)

                            {{ \Illuminate\Support\Carbon::parse(
                                $order->cancelled_at
                            )->format('M d, Y h:i A') }}

                        @else

                            Not available

                        @endif

                        </strong>

                    </div>

                </div>

            </div>

        @endif


        {{-- =====================================================
             DETAILS
        ====================================================== --}}

        <div class="admin-order-details-grid">


            {{-- CUSTOMER + DELIVERY --}}

            <div>

                {{-- CUSTOMER INFORMATION --}}

                <div class="admin-details-card">

                    <div class="details-card-header">

                        <div class="details-icon">
                            👤
                        </div>

                        <div>

                            <h2>
                                Customer Information
                            </h2>

                            <p>
                                Customer who placed this order.
                            </p>

                        </div>

                    </div>


                    <div class="admin-info-list">

                        <div>

                            <span>
                                Name
                            </span>

                            <strong>
                                {{ $order->full_name }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Account Email
                            </span>

                            <strong>
                                {{ $order->user->email }}
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

                    </div>

                </div>


                {{-- DELIVERY INFORMATION --}}

                <div class="admin-details-card">

                    <div class="details-card-header">

                        <div class="details-icon">
                            📦
                        </div>

                        <div>

                            <h2>
                                Delivery Information
                            </h2>

                            <p>
                                Delivery details provided by the customer.
                            </p>

                        </div>

                    </div>


                    <div class="admin-info-list">

                        <div>

                            <span>
                                Address
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

            </div>


            {{-- ITEMS + PAYMENT --}}

            <div>

                {{-- ORDER ITEMS --}}

                <div class="admin-details-card">

                    <div class="details-card-header">

                        <div class="details-icon">
                            🍽️
                        </div>

                        <div>

                            <h2>
                                Order Items
                            </h2>

                            <p>
                                Food included in this order.
                            </p>

                        </div>

                    </div>


                    <div class="admin-order-items-list">

                        @foreach($order->orderItems as $item)

                            <div class="admin-order-item">

                                <div class="admin-order-item-image">

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


                                <div>

                                    <strong>
                                        {{ $item->product->name }}
                                    </strong>

                                    <span>
                                        {{ $item->quantity }}
                                        ×
                                        ₱{{ number_format(
                                            $item->unit_price,
                                            2
                                        ) }}
                                    </span>

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


                    {{-- PRICE SUMMARY --}}

                    <div class="admin-price-summary">

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


                        <div class="admin-grand-total">

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


                {{-- PAYMENT INFORMATION --}}

                <div class="admin-details-card">

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


                    <div class="admin-payment-row">

                        <span>
                            Payment Method
                        </span>

                        <strong>
                            {{ $order->payment_method }}
                        </strong>

                    </div>


                    <div class="admin-payment-row">

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