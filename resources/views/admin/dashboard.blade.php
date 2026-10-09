@extends('layouts.app')

@section('content')

<section class="admin-dashboard-section">

    <div class="container">


        {{-- =====================================================
             DASHBOARD HEADER
        ====================================================== --}}

        <div class="admin-dashboard-header">

            <div>

                <span class="section-label">
                    ADMIN PANEL
                </span>

                <h1>
                    Dashboard
                </h1>

                <p>
                    Welcome back, {{ auth()->user()->name }}.
                    Here's what's happening with FoodieHub.
                </p>

            </div>


            <div class="admin-user-badge">

                <span class="admin-user-icon">
                    🛡️
                </span>

                <div>

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Administrator
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
             STATISTICS
        ====================================================== --}}

        <div class="admin-stats-grid">


            {{-- TOTAL ORDERS --}}

            <div class="admin-stat-card">

                <div class="admin-stat-icon">
                    📦
                </div>

                <div>

                    <span>
                        Total Orders
                    </span>

                    <strong>
                        {{ number_format($totalOrders) }}
                    </strong>

                </div>

            </div>


            {{-- PENDING ORDERS --}}

            <div class="admin-stat-card">

                <div class="admin-stat-icon">
                    ⏳
                </div>

                <div>

                    <span>
                        Pending Orders
                    </span>

                    <strong>
                        {{ number_format($pendingOrders) }}
                    </strong>

                </div>

            </div>


            {{-- TOTAL PRODUCTS --}}

            <div class="admin-stat-card">

                <div class="admin-stat-icon">
                    🍔
                </div>

                <div>

                    <span>
                        Total Products
                    </span>

                    <strong>
                        {{ number_format($totalProducts) }}
                    </strong>

                </div>

            </div>


            {{-- CUSTOMERS --}}

            <div class="admin-stat-card">

                <div class="admin-stat-icon">
                    👥
                </div>

                <div>

                    <span>
                        Customers
                    </span>

                    <strong>
                        {{ number_format($totalUsers) }}
                    </strong>

                </div>

            </div>


            {{-- COMPLETED REVENUE --}}

            <div class="admin-stat-card revenue-card">

                <div class="admin-stat-icon">
                    💰
                </div>

                <div>

                    <span>
                        Completed Revenue
                    </span>

                    <strong>
                        ₱{{ number_format(
                            $totalRevenue,
                            2
                        ) }}
                    </strong>

                </div>

            </div>


            {{-- CATEGORIES --}}

            <div class="admin-stat-card">

                <div class="admin-stat-icon">
                    🗂️
                </div>

                <div>

                    <span>
                        Categories
                    </span>

                    <strong>
                        {{ number_format($totalCategories) }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =====================================================
             DRIVER MANAGEMENT
        ====================================================== --}}

        <div class="admin-driver-management-card">

            <div class="admin-driver-management-content">


                {{-- ICON --}}

                <div class="admin-driver-management-icon">
                    🚚
                </div>


                {{-- TEXT --}}

                <div class="admin-driver-management-text">

                    <span class="section-label">
                        DELIVERY TEAM
                    </span>

                    <h2>
                        Driver Management
                    </h2>

                    <p>
                        Manage your delivery drivers and create
                        new driver accounts for FoodieHub orders.
                    </p>

                </div>


                {{-- COUNT --}}

                <div class="admin-driver-management-count">

                    <span>
                        Total Drivers
                    </span>

                    <strong>
                        {{ number_format($totalDrivers) }}
                    </strong>

                </div>


                {{-- BUTTON --}}

                <div class="admin-driver-management-action">

                    <a
                        href="{{ route('admin.drivers.index') }}"
                        class="admin-manage-drivers-button"
                    >
                        Manage Drivers →
                    </a>

                </div>

            </div>

        </div>


        {{-- =====================================================
             MENU MANAGEMENT
        ====================================================== --}}

        <div class="admin-menu-management-card">

            <div class="admin-menu-management-content">


                {{-- ICON --}}

                <div class="admin-menu-management-icon">
                    🍽️
                </div>


                {{-- TEXT --}}

                <div class="admin-menu-management-text">

                    <span class="section-label">
                        MENU
                    </span>

                    <h2>
                        Menu Management
                    </h2>

                    <p>
                        Add, view, and delete food items from the
                        FoodieHub menu available to customers.
                    </p>

                </div>


                {{-- COUNT --}}

                <div class="admin-menu-management-count">

                    <span>
                        Total Menu Items
                    </span>

                    <strong>
                        {{ number_format($totalProducts) }}
                    </strong>

                </div>


                {{-- BUTTON --}}

                <div class="admin-menu-management-action">

                    <a
                        href="{{ route('admin.menu.index') }}"
                        class="admin-manage-menu-button"
                    >
                        Manage Menu →
                    </a>

                </div>

            </div>

        </div>


        {{-- =====================================================
             STORE STATUS
        ====================================================== --}}

        <div class="admin-store-status-card">

            <div class="admin-store-status-content">


                {{-- ICON --}}

                <div class="admin-store-status-icon">
                    🏪
                </div>


                {{-- TEXT --}}

                <div class="admin-store-status-text">

                    <span class="section-label">
                        STORE
                    </span>

                    <h2>
                        Store Status
                    </h2>

                    <p>
                        Control whether FoodieHub is currently
                        accepting new orders.
                    </p>

                </div>


                {{-- BUTTON --}}

                <div class="admin-store-status-action">

                    <a
                        href="{{ route('admin.store-status.edit') }}"
                        class="admin-manage-store-status-button"
                    >
                        Manage Store Status →
                    </a>

                </div>

            </div>

        </div>


        {{-- =====================================================
             DASHBOARD CONTENT
        ====================================================== --}}

        <div class="admin-dashboard-grid">


            {{-- =================================================
                 RECENT ORDERS
            ================================================== --}}

            <div class="admin-panel">


                {{-- HEADER --}}

                <div class="admin-panel-header">

                    <div>

                        <span class="section-label">
                            ORDERS
                        </span>

                        <h2>
                            Recent Orders
                        </h2>

                    </div>


                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="admin-manage-button"
                    >
                        Manage Orders →
                    </a>

                </div>


                {{-- EMPTY --}}

                @if($recentOrders->isEmpty())

                    <div class="admin-empty">
                        No orders yet.
                    </div>


                @else

                    <div class="admin-order-list">


                        @foreach($recentOrders as $order)

                            <div class="admin-order-row">


                                {{-- ORDER NUMBER --}}

                                <div class="admin-order-number">

                                    <span>
                                        ORDER
                                    </span>

                                    <strong>
                                        #{{ $order->id }}
                                    </strong>

                                </div>


                                {{-- CUSTOMER --}}

                                <div class="admin-order-customer">

                                    <strong>
                                        {{ $order->full_name }}
                                    </strong>

                                    <span>
                                        {{ $order->payment_method }}
                                    </span>

                                </div>


                                {{-- TOTAL --}}

                                <div class="admin-order-total">

                                    ₱{{ number_format(
                                        $order->total,
                                        2
                                    ) }}

                                </div>


                                {{-- STATUS --}}

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

                        @endforeach


                    </div>

                @endif

            </div>


            {{-- =================================================
                 RECENT PRODUCTS
            ================================================== --}}

            <div class="admin-panel">


                {{-- HEADER --}}

                <div class="admin-panel-header">

                    <div>

                        <span class="section-label">
                            MENU
                        </span>

                        <h2>
                            Recent Products
                        </h2>

                    </div>


                    <a
                        href="{{ route('admin.menu.index') }}"
                        class="admin-manage-button"
                    >
                        Manage Menu →
                    </a>

                </div>


                {{-- EMPTY --}}

                @if($recentProducts->isEmpty())

                    <div class="admin-empty">
                        No products yet.
                    </div>


                @else

                    <div class="admin-product-list">


                        @foreach($recentProducts as $product)

                            <div class="admin-product-row">


                                {{-- PRODUCT IMAGE --}}

                                <div class="admin-product-image">

                                    @if($product->image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $product->image
                                            ) }}"
                                            alt="{{ $product->name }}"
                                        >

                                    @else

                                        🍽️

                                    @endif

                                </div>


                                {{-- PRODUCT INFORMATION --}}

                                <div class="admin-product-info">

                                    <strong>
                                        {{ $product->name }}
                                    </strong>

                                    <span>
                                        {{ $product->category?->name
                                            ?? 'No Category' }}
                                    </span>

                                </div>


                                {{-- PRICE --}}

                                <div class="admin-product-price">

                                    ₱{{ number_format(
                                        $product->price,
                                        2
                                    ) }}

                                </div>


                                {{-- AVAILABILITY --}}

                                <span
                                    class="availability-badge
                                    {{ $product->is_available
                                        ? 'available'
                                        : 'unavailable' }}"
                                >

                                    {{ $product->is_available
                                        ? 'Available'
                                        : 'Unavailable' }}

                                </span>

                            </div>

                        @endforeach


                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

@endsection