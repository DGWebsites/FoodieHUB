@extends('layouts.app')

@section('content')

<section class="admin-orders-section">

    <div class="container">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="admin-page-header">

            <div>

                <span class="section-label">
                    ADMIN PANEL
                </span>

                <h1>
                    Orders
                </h1>

                <p>
                    Manage customer orders and update their status.
                </p>

            </div>


            <a
                href="{{ route('admin.dashboard') }}"
                class="admin-back-button"
            >
                ← Dashboard
            </a>

        </div>


        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div class="order-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- =====================================================
             SEARCH & FILTERS
        ====================================================== --}}

        <form
            action="{{ route('admin.orders.index') }}"
            method="GET"
            class="admin-order-filters"
        >

            <div class="admin-order-filter-search">

                <label for="search">
                    Search Orders
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Order #, customer name, or email"
                >

            </div>


            <div class="admin-order-filter-field">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                >

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="Pending"
                        {{ $status === 'Pending' ? 'selected' : '' }}
                    >
                        Pending
                    </option>

                    <option
                        value="Confirmed"
                        {{ $status === 'Confirmed' ? 'selected' : '' }}
                    >
                        Confirmed
                    </option>

                    <option
                        value="Preparing"
                        {{ $status === 'Preparing' ? 'selected' : '' }}
                    >
                        Preparing
                    </option>

                    <option
                        value="Ready"
                        {{ $status === 'Ready' ? 'selected' : '' }}
                    >
                        Ready
                    </option>

                    <option
                        value="Out for Delivery"
                        {{ $status === 'Out for Delivery' ? 'selected' : '' }}
                    >
                        Out for Delivery
                    </option>

                    <option
                        value="Delivered"
                        {{ $status === 'Delivered' ? 'selected' : '' }}
                    >
                        Delivered
                    </option>

                    <option
                        value="Completed"
                        {{ $status === 'Completed' ? 'selected' : '' }}
                    >
                        Completed
                    </option>

                    <option
                        value="Cancelled"
                        {{ $status === 'Cancelled' ? 'selected' : '' }}
                    >
                        Cancelled
                    </option>

                    <option
                        value="Rejected"
                        {{ $status === 'Rejected' ? 'selected' : '' }}
                    >
                        Rejected
                    </option>

                </select>

            </div>


            <div class="admin-order-filter-field">

                <label for="driver_id">
                    Driver
                </label>

                <select
                    id="driver_id"
                    name="driver_id"
                >

                    <option value="">
                        All Drivers
                    </option>

                    <option
                        value="unassigned"
                        {{ $driverId === 'unassigned' ? 'selected' : '' }}
                    >
                        Unassigned
                    </option>

                    @foreach($drivers as $driver)

                        <option
                            value="{{ $driver->id }}"
                            {{ (string) $driverId === (string) $driver->id ? 'selected' : '' }}
                        >
                            {{ $driver->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="admin-order-filter-actions">

                <button
                    type="submit"
                    class="admin-order-filter-button"
                >
                    Search / Filter
                </button>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="admin-order-reset-button"
                >
                    Reset
                </a>

            </div>

        </form>


        {{-- =====================================================
             ORDERS
        ====================================================== --}}

        @if($orders->isEmpty())

            <div class="admin-orders-empty">

                <div class="orders-empty-icon">
                    📦
                </div>

                @if($search !== '' || $status !== '' || $driverId !== '')

                    <h2>
                        No Matching Orders
                    </h2>

                    <p>
                        No orders match your current search or filters.
                    </p>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="admin-view-order-button"
                    >
                        Clear Filters
                    </a>

                @else

                    <h2>
                        No Orders Yet
                    </h2>

                    <p>
                        Customer orders will appear here.
                    </p>

                @endif

            </div>

        @else

            <div class="admin-orders-card">

                <div class="admin-orders-header">

                    <h2>
                        All Orders
                    </h2>

                    <span>
                        {{ $orders->count() }} total
                    </span>

                </div>


                <div class="admin-orders-list">

                    @foreach($orders as $order)

                        <div class="admin-order-card">

                            {{-- Order Number --}}

                            <div class="admin-order-id">

                                <span>
                                    ORDER
                                </span>

                                <strong>
                                    #{{ $order->id }}
                                </strong>

                            </div>


                            {{-- Customer --}}

                            <div class="admin-order-customer">

                                <strong>
                                    {{ $order->full_name }}
                                </strong>

                                <span>
                                    {{ $order->phone }}
                                </span>

                            </div>


                            {{-- Date --}}

                            <div class="admin-order-date">

                                <span>
                                    Date
                                </span>

                                <strong>
                                    {{ $order->created_at->format(
                                        'M d, Y'
                                    ) }}
                                </strong>

                            </div>


                            {{-- Items --}}

                            <div class="admin-order-items-count">

                                <span>
                                    Items
                                </span>

                                <strong>
                                    {{ $order->order_items_count }}
                                </strong>

                            </div>


                            {{-- Total --}}

                            <div class="admin-order-price">

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


                            {{-- Status --}}

                            <div>

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


                            {{-- Driver --}}

                            <div class="admin-order-driver">

                                <span>
                                    Driver
                                </span>

                                <strong>
                                    {{ $order->driver?->name ?? 'Unassigned' }}
                                </strong>

                            </div>


                            {{-- View Button --}}

                            <div>

                                <a
                                    href="{{ route(
                                        'admin.orders.show',
                                        $order
                                    ) }}"
                                    class="admin-view-order-button"
                                >
                                    View →
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>

</section>

@endsection