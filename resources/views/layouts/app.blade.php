<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $title ?? 'FoodieHub' }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>

    {{-- =====================================================
         NAVBAR
    ====================================================== --}}

    <header class="site-header">
        <div class="container navbar">
            <a href="{{ route('home') }}" class="fh-navbar-brand" aria-label="FoodieHub home">
                <span class="fh-navbar-brand-icon" aria-hidden="true">🍴</span>
                <span><span class="brand-foodie">Foodie</span><span class="brand-hub">Hub</span></span>
            </a>

            <button
                type="button"
                class="mobile-menu-toggle"
                id="mobileMenuToggle"
                aria-label="Open navigation menu"
                aria-controls="mainNavigation"
                aria-expanded="false"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>

            <nav id="mainNavigation" class="fh-main-navigation" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="fh-nav-link">Home</a>
                <a href="{{ route('status') }}" class="fh-nav-link">Status</a>
                <a href="{{ route('tutorial') }}" class="fh-nav-link">Tutorial</a>
                <a href="{{ route('support') }}" class="fh-nav-link">Support</a>
                <a href="{{ route('about') }}" class="fh-nav-link">About Us</a>

                @auth
                    @include('partials.notifications')
                @endauth

                <button
                    type="button"
                    class="nav-cart-button"
                    onclick="openCart()"
                    aria-label="Open shopping cart"
                >
                    <span aria-hidden="true">🛒</span>
                    <span>Cart</span>
                    <span class="cart-count" aria-live="polite">0</span>
                </button>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link">
                            🛡️ Admin Dashboard
                        </a>

                        <form method="POST" action="{{ route('admin.logout') }}" class="fh-nav-auth-form">
                            @csrf
                            <button type="submit" class="logout-button">Logout</button>
                        </form>

                    @elseif(auth()->user()->role === 'driver')
                        <a href="{{ route('driver.dashboard') }}" class="admin-nav-link">
                            🚚 Driver Dashboard
                        </a>

                        <span class="user-name">{{ auth()->user()->name }}</span>

                        <form method="POST" action="{{ route('driver.logout') }}" class="fh-nav-auth-form">
                            @csrf
                            <button type="submit" class="logout-button">Logout</button>
                        </form>

                    @else
                        <a href="{{ route('orders.index') }}" class="fh-nav-link">My Orders</a>
                        <span class="user-name">{{ auth()->user()->name }}</span>

                        <form method="POST" action="{{ route('logout') }}" class="fh-nav-auth-form">
                            @csrf
                            <button type="submit" class="logout-button">Logout</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="login-link">Login</a>
                    <a href="{{ route('register') }}" class="register-button">Register</a>
                @endauth
            </nav>
        </div>
    </header>



    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main>

        @yield('content')

    </main>



    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <footer class="site-footer">

        <div class="container">

            <div class="footer-content">


                {{-- Brand / Description --}}

                <div class="footer-brand-column">

                    <a
                        href="{{ route('home') }}"
                        class="footer-brand"
                    >

                        🍴
                        Foodie<span>Hub</span>

                    </a>


                    <p class="footer-description">

                        Fresh food, easy ordering,
                        and fast delivery made for
                        your cravings.

                    </p>

                </div>



                {{-- Shop / Role Links --}}

                <div class="footer-column">

                    @auth

                        @if(auth()->user()->role === 'admin')

                            <h3>
                                MANAGEMENT
                            </h3>

                            <a href="{{ route('admin.dashboard') }}">
                                Admin Dashboard
                            </a>

                            <a href="{{ route('admin.orders.index') }}">
                                Manage Orders
                            </a>

                            <a href="{{ route('admin.drivers.index') }}">
                                Driver Management
                            </a>


                        @elseif(auth()->user()->role === 'driver')

                            <h3>
                                DELIVERY
                            </h3>

                            <a href="{{ route('driver.dashboard') }}">
                                Driver Dashboard
                            </a>

                            <a href="{{ route('driver.dashboard') }}">
                                Assigned Orders
                            </a>


                        @else

                            <h3>
                                SHOP
                            </h3>

                            <a href="{{ route('home') }}">
                                Browse Menu
                            </a>

                            <a href="{{ route('orders.index') }}">
                                My Orders
                            </a>

                            <a
                                href="{{ route('home') }}"
                                onclick="openCart(); return false;"
                            >
                                Shopping Cart
                            </a>

                        @endif


                    @else

                        <h3>
                            SHOP
                        </h3>

                        <a href="{{ route('home') }}">
                            Browse Menu
                        </a>

                        <a href="{{ route('login') }}">
                            Login
                        </a>

                        <a href="{{ route('register') }}">
                            Register
                        </a>

                    @endauth

                </div>



                {{-- Company --}}

                <div class="footer-column">

                    <h3>
                        COMPANY
                    </h3>

                    <a href="{{ route('about') }}">
                        About Us
                    </a>

                    <a href="{{ route('tutorial') }}">
                        How It Works
                    </a>

                    <a href="{{ route('status') }}">
                        Service Status
                    </a>

                </div>



                {{-- Help --}}

                <div class="footer-column">

                    <h3>
                        HELP
                    </h3>

                    <a href="{{ route('support') }}">
                        Support
                    </a>

                    <a href="{{ route('tutorial') }}">
                        Tutorial
                    </a>

                    <a href="{{ route('status') }}">
                        Delivery Status
                    </a>

                </div>



                {{-- Account / Information --}}

                <div class="footer-column">

                    <h3>
                        INFORMATION
                    </h3>

                    <a href="{{ route('about') }}">
                        About FoodieHub
                    </a>

                    <a href="{{ route('support') }}">
                        Contact Support
                    </a>

                    <a href="{{ route('home') }}">
                        Start Ordering
                    </a>

                </div>

            </div>



            {{-- Footer Bottom --}}

            <div class="footer-bottom">

                <p>
                    &copy; {{ date('Y') }} FoodieHub.
                    All rights reserved.
                </p>

                <p>
                    Fresh food. Fast delivery.
                </p>

            </div>

        </div>

    </footer>



    {{-- =====================================================
         CART OVERLAY
    ====================================================== --}}

    <div
        id="cartOverlay"
        class="cart-overlay"
        onclick="closeCart(event)"
    >
    </div>



    {{-- =====================================================
         CART DRAWER
    ====================================================== --}}

    <aside
        id="cartDrawer"
        class="cart-drawer"
    >

        {{-- Cart Header --}}

        <div class="cart-header">

            <div>

                <span class="cart-eyebrow">
                    YOUR ORDER
                </span>

                <h2>
                    Shopping Cart
                </h2>

            </div>


            <button
                type="button"
                class="cart-close"
                onclick="closeCart()"
                aria-label="Close cart"
            >
                ×
            </button>

        </div>



        {{-- Cart Items --}}

        <div
            id="cartItems"
            class="cart-items"
        >

            <div class="cart-loading">
                Loading cart...
            </div>

        </div>



        {{-- Cart Footer --}}

        <div class="cart-footer">

            <div class="cart-subtotal">

                <span>
                    Subtotal
                </span>

                <strong id="cartSubtotal">
                    ₱0.00
                </strong>

            </div>


            <p class="cart-note">

                Delivery fee and final total will be calculated
                at checkout.

            </p>


            <a
                href="{{ route('checkout.index') }}"
                class="checkout-button"
                id="checkoutButton"
            >

                <span>
                    Proceed to Checkout
                </span>

                <span>
                    →
                </span>

            </a>


            <button
                type="button"
                class="clear-cart-button"
                onclick="clearCart()"
            >
                Clear Cart
            </button>

        </div>

    </aside>



    {{-- =====================================================
         CLEAR CART MODAL
    ====================================================== --}}

    <div
        id="fhClearCartModal"
        class="fh-clear-cart-modal"
        aria-hidden="true"
    >

        <div
            class="fh-clear-cart-overlay"
            data-clear-cart-cancel
        >
        </div>


        <div
            class="fh-clear-cart-box"
            role="dialog"
            aria-modal="true"
            aria-labelledby="fhClearCartTitle"
        >

            <div class="fh-clear-cart-icon">
                🛒
            </div>


            <h2 id="fhClearCartTitle">
                Clear Your Cart?
            </h2>


            <p>
                Are you sure you want to remove
                all items from your cart?
            </p>


            <span class="fh-clear-cart-warning">
                This action cannot be undone.
            </span>


            <div class="fh-clear-cart-actions">

                <button
                    type="button"
                    class="fh-clear-cart-cancel"
                    data-clear-cart-cancel
                >
                    Keep Items
                </button>


                <button
                    type="button"
                    class="fh-clear-cart-confirm"
                    id="fhClearCartConfirm"
                >
                    🗑 Clear Cart
                </button>

            </div>

        </div>

    </div>



    {{-- =====================================================
         STORE STATUS DATA
    ====================================================== --}}

    @php

        $storeSetting = \App\Models\StoreSetting::first();

        $storeIsOpen = $storeSetting
            ? $storeSetting->is_open
            : true;

    @endphp


    <div
        id="fhStoreStatusData"
        data-store-open="{{ $storeIsOpen ? '1' : '0' }}"
        hidden
    >
    </div>



    {{-- =====================================================
         CART STORE CLOSED MODAL
    ====================================================== --}}

    <div
        id="fhCartStoreClosedModal"
        class="fh-cart-store-closed-modal"
        aria-hidden="true"
    >

        <div
            class="fh-cart-store-closed-overlay"
            data-cart-store-closed
        >
        </div>


        <div
            class="fh-cart-store-closed-box"
            role="dialog"
            aria-modal="true"
            aria-labelledby="fhCartStoreClosedTitle"
        >

            <div class="fh-cart-store-closed-icon">
                🔴
            </div>


            <span class="fh-cart-store-closed-label">
                STORE STATUS
            </span>


            <h2 id="fhCartStoreClosedTitle">
                FoodieHub is Closed
            </h2>


            <p>
                We're currently not accepting new orders.
                Please check back later when the store is open.
            </p>


            <button
                type="button"
                class="fh-cart-store-closed-button"
                data-cart-store-closed
            >
                Got It
            </button>

        </div>

    </div>



    {{-- =====================================================
         CART JAVASCRIPT
    ====================================================== --}}

    <script>

        const cartDrawer =
            document.getElementById(
                'cartDrawer'
            );

        const cartOverlay =
            document.getElementById(
                'cartOverlay'
            );

        const cartItems =
            document.getElementById(
                'cartItems'
            );

        const cartSubtotal =
            document.getElementById(
                'cartSubtotal'
            );


        /* =====================================================
           STORE STATUS
        ===================================================== */

        function isStoreOpen()
        {
            const storeStatusData =
                document.getElementById(
                    'fhStoreStatusData'
                );

            if (!storeStatusData) {

                return true;

            }

            return (
                storeStatusData.dataset.storeOpen ===
                '1'
            );

        }



        /* =====================================================
           OPEN CART
        ===================================================== */

        function openCart()
        {

            if (
                !cartDrawer ||
                !cartOverlay
            ) {

                return;

            }


            /* Hide FoodieHub Assistant */

            const assistant =
                document.getElementById(
                    'foodiehubAssistant'
                );

            const assistantWindow =
                document.getElementById(
                    'fhAssistantWindow'
                );

            const assistantButton =
                document.getElementById(
                    'fhAssistantOpen'
                );


            if (assistantWindow) {

                assistantWindow.classList.remove(
                    'open'
                );

                assistantWindow.setAttribute(
                    'aria-hidden',
                    'true'
                );

            }


            if (assistantButton) {

                assistantButton.style.display =
                    'flex';

            }


            if (assistant) {

                assistant.style.display =
                    'none';

            }


            /* Open Cart */

            cartDrawer.classList.add(
                'open'
            );

            cartOverlay.classList.add(
                'show'
            );

            document.body.classList.add(
                'cart-open'
            );

            loadCart();

        }



        /* =====================================================
           CLOSE CART
        ====================================================== */

        function closeCart(event = null)
        {

            if (
                event &&
                event.target !== cartOverlay
            ) {

                return;

            }


            if (cartDrawer) {

                cartDrawer.classList.remove(
                    'open'
                );

            }


            if (cartOverlay) {

                cartOverlay.classList.remove(
                    'show'
                );

            }


            document.body.classList.remove(
                'cart-open'
            );


            /* Bring FoodieHub Assistant back */

            const assistant =
                document.getElementById(
                    'foodiehubAssistant'
                );

            const assistantButton =
                document.getElementById(
                    'fhAssistantOpen'
                );


            if (assistant) {

                assistant.style.display =
                    'block';

            }


            if (assistantButton) {

                assistantButton.style.display =
                    'flex';

            }

        }



        /* =====================================================
           LOAD CART
        ====================================================== */

        async function loadCart()
        {

            if (!cartItems) {

                return;

            }


            cartItems.innerHTML = `

                <div class="cart-loading">
                    Loading cart...
                </div>

            `;


            try {

                const response =
                    await fetch(
                        "{{ route('cart.data') }}",
                        {
                            headers: {
                                'Accept':
                                    'application/json'
                            }
                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    throw new Error(
                        'Unable to load cart.'
                    );

                }


                renderCart(data);

            }

            catch (error) {

                cartItems.innerHTML = `

                    <div class="cart-empty">

                        <div class="cart-empty-icon">
                            ⚠️
                        </div>

                        <h3>
                            Unable to load cart
                        </h3>

                        <p>
                            Please refresh the page
                            and try again.
                        </p>

                    </div>

                `;

            }

        }



        /* =====================================================
           ADD PRODUCT
        ====================================================== */

        async function addToCart(productId)
        {

            try {

                const response =
                    await fetch(
                        `/cart/add/${productId}`,
                        {
                            method: 'POST',

                            headers: {

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute(
                                            'content'
                                        ),

                                'Accept':
                                    'application/json',

                                'Content-Type':
                                    'application/json'

                            },

                            body:
                                JSON.stringify({
                                    quantity: 1
                                })

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Unable to add product.'
                    );

                }


                updateCartCount(
                    data.count
                );


                openCart();

            }

            catch (error) {

                alert(
                    error.message
                );

            }

        }



        /* =====================================================
           BUY NOW
        ====================================================== */

        async function buyNow(productId)
        {

            if (!isStoreOpen()) {

                openCartStoreClosedModal();

                return;

            }


            try {

                const response =
                    await fetch(
                        `/cart/add/${productId}`,
                        {
                            method: 'POST',

                            headers: {

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute(
                                            'content'
                                        ),

                                'Accept':
                                    'application/json',

                                'Content-Type':
                                    'application/json'

                            },

                            body:
                                JSON.stringify({
                                    quantity: 1
                                })

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Unable to add product.'
                    );

                }


                updateCartCount(
                    data.count
                );


                window.location.href =
                    "{{ route('checkout.index') }}";

            }

            catch (error) {

                alert(
                    error.message
                );

            }

        }



        /* =====================================================
           RENDER CART
        ====================================================== */

        function renderCart(data)
        {

            if (!cartItems) {

                return;

            }


            updateCartCount(
                data.count
            );


            if (cartSubtotal) {

                cartSubtotal.textContent =
                    `₱${Number(
                        data.subtotal
                    ).toFixed(2)}`;

            }


            const items =
                Object.values(
                    data.cart
                );


            if (items.length === 0) {

                cartItems.innerHTML = `

                    <div class="cart-empty">

                        <div class="cart-empty-icon">
                            🛒
                        </div>

                        <h3>
                            Your cart is empty
                        </h3>

                        <p>
                            Add some delicious food
                            to get started.
                        </p>

                    </div>

                `;

                return;

            }


            cartItems.innerHTML =
                items.map(
                    item => {

                        const icon =
                            getProductIcon(
                                item.category
                            );


                        const subtotal =
                            Number(item.price) *
                            Number(item.quantity);


                        return `

                            <div class="cart-item">

                                <div class="cart-item-image">

                                    ${
                                        item.image
                                            ? `

                                                <img
                                                    src="/storage/${item.image}"
                                                    alt="${escapeHtml(
                                                        item.name
                                                    )}"
                                                >

                                              `
                                            : icon
                                    }

                                </div>


                                <div class="cart-item-info">

                                    <h4>
                                        ${escapeHtml(
                                            item.name
                                        )}
                                    </h4>


                                    <span>
                                        ₱${Number(
                                            item.price
                                        ).toFixed(2)}
                                    </span>


                                    <div
                                        class="cart-item-bottom"
                                    >

                                        <div
                                            class="quantity-control"
                                        >

                                            <button
                                                type="button"
                                                onclick="changeQuantity(
                                                    ${item.id},
                                                    ${Number(
                                                        item.quantity
                                                    ) - 1}
                                                )"
                                            >
                                                −
                                            </button>


                                            <strong>
                                                ${item.quantity}
                                            </strong>


                                            <button
                                                type="button"
                                                onclick="changeQuantity(
                                                    ${item.id},
                                                    ${Number(
                                                        item.quantity
                                                    ) + 1}
                                                )"
                                            >
                                                +
                                            </button>

                                        </div>


                                        <strong>
                                            ₱${subtotal.toFixed(2)}
                                        </strong>

                                    </div>

                                </div>


                                <button
                                    type="button"
                                    class="remove-cart-item"
                                    onclick="removeFromCart(
                                        ${item.id}
                                    )"
                                    aria-label="Remove item"
                                >
                                    ×
                                </button>

                            </div>

                        `;

                    }
                ).join('');

        }



        /* =====================================================
           CHANGE QUANTITY
        ====================================================== */

        async function changeQuantity(
            productId,
            quantity
        )
        {

            try {

                const response =
                    await fetch(
                        `/cart/update/${productId}`,
                        {
                            method: 'PATCH',

                            headers: {

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute(
                                            'content'
                                        ),

                                'Accept':
                                    'application/json',

                                'Content-Type':
                                    'application/json'

                            },

                            body:
                                JSON.stringify({
                                    quantity: quantity
                                })

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Unable to update cart.'
                    );

                }


                renderCart(data);

            }

            catch (error) {

                alert(
                    error.message
                );

            }

        }



        /* =====================================================
           REMOVE PRODUCT
        ====================================================== */

        async function removeFromCart(
            productId
        )
        {

            try {

                const response =
                    await fetch(
                        `/cart/remove/${productId}`,
                        {
                            method: 'DELETE',

                            headers: {

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute(
                                            'content'
                                        ),

                                'Accept':
                                    'application/json'

                            }

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Unable to remove product.'
                    );

                }


                renderCart(data);

            }

            catch (error) {

                alert(
                    error.message
                );

            }

        }



        /* =====================================================
           CLEAR CART
        ====================================================== */

        async function clearCart()
        {

            const modal =
                document.getElementById(
                    'fhClearCartModal'
                );


            if (!modal) {

                return;

            }


            modal.classList.add(
                'open'
            );


            modal.setAttribute(
                'aria-hidden',
                'false'
            );


            document.body.style.overflow =
                'hidden';

        }



        /* =====================================================
           UPDATE CART COUNT
        ====================================================== */

        function updateCartCount(count)
        {

            const badges =
                document.querySelectorAll(
                    '.cart-count'
                );


            badges.forEach(
                badge => {

                    badge.textContent =
                        count;


                    badge.style.display =
                        count > 0
                            ? 'inline-flex'
                            : 'none';

                }
            );

        }



        /* =====================================================
           PRODUCT ICON
        ====================================================== */

        function getProductIcon(
            category
        )
        {

            switch (
                (category || '').toLowerCase()
            ) {

                case 'burgers':
                    return '🍔';

                case 'pizza':
                    return '🍕';

                case 'chicken':
                    return '🍗';

                case 'beef':
                    return '🥩';

                case 'pasta':
                    return '🍝';

                case 'snacks':
                    return '🍟';

                case 'drinks':
                    return '🥤';

                case 'desserts':
                    return '🍰';

                default:
                    return '🍽️';

            }

        }



        /* =====================================================
           ESCAPE HTML
        ====================================================== */

        function escapeHtml(
            value
        )
        {

            const div =
                document.createElement(
                    'div'
                );


            div.textContent =
                value;


            return div.innerHTML;

        }



        /* =====================================================
           CART STORE CLOSED MODAL
        ====================================================== */

        function openCartStoreClosedModal()
        {

            const modal =
                document.getElementById(
                    'fhCartStoreClosedModal'
                );


            if (!modal) {

                return;

            }


            modal.classList.add(
                'open'
            );


            modal.setAttribute(
                'aria-hidden',
                'false'
            );


            document.body.style.overflow =
                'hidden';

        }


        function closeCartStoreClosedModal()
        {

            const modal =
                document.getElementById(
                    'fhCartStoreClosedModal'
                );


            if (!modal) {

                return;

            }


            modal.classList.remove(
                'open'
            );


            modal.setAttribute(
                'aria-hidden',
                'true'
            );


            document.body.style.overflow =
                '';

        }



        /* =====================================================
           DOM READY
        ====================================================== */

        document.addEventListener(
            'DOMContentLoaded',
            function ()
            {

                /* =========================
                   CLEAR CART MODAL
                ========================== */

                const clearModal =
                    document.getElementById(
                        'fhClearCartModal'
                    );


                const clearConfirmButton =
                    document.getElementById(
                        'fhClearCartConfirm'
                    );


                const clearCancelButtons =
                    document.querySelectorAll(
                        '[data-clear-cart-cancel]'
                    );


                function closeClearCartModal()
                {

                    if (!clearModal) {

                        return;

                    }


                    clearModal.classList.remove(
                        'open'
                    );


                    clearModal.setAttribute(
                        'aria-hidden',
                        'true'
                    );


                    document.body.style.overflow =
                        '';

                }


                clearCancelButtons.forEach(
                    function (button)
                    {

                        button.addEventListener(
                            'click',
                            function ()
                            {

                                closeClearCartModal();

                            }
                        );

                    }
                );


                if (clearConfirmButton) {

                    clearConfirmButton.addEventListener(
                        'click',
                        async function ()
                        {

                            try {

                                clearConfirmButton.disabled =
                                    true;


                                clearConfirmButton.textContent =
                                    'Clearing...';


                                const response =
                                    await fetch(
                                        "{{ route('cart.clear') }}",
                                        {
                                            method: 'DELETE',

                                            headers: {

                                                'X-CSRF-TOKEN':
                                                    document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
                                                        )
                                                        .getAttribute(
                                                            'content'
                                                        ),

                                                'Accept':
                                                    'application/json'

                                            }

                                        }
                                    );


                                const data =
                                    await response.json();


                                if (!response.ok) {

                                    throw new Error(
                                        data.message ||
                                        'Unable to clear cart.'
                                    );

                                }


                                closeClearCartModal();

                                renderCart(
                                    data
                                );

                            }

                            catch (error) {

                                closeClearCartModal();

                                alert(
                                    error.message
                                );

                            }

                            finally {

                                clearConfirmButton.disabled =
                                    false;


                                clearConfirmButton.textContent =
                                    '🗑 Clear Cart';

                            }

                        }
                    );

                }



                /* =========================
                   STORE CLOSED CHECKOUT
                ========================== */

                const checkoutButtons =
                    document.querySelectorAll(
                        '.checkout-button'
                    );


                checkoutButtons.forEach(
                    function (button)
                    {

                        button.addEventListener(
                            'click',
                            function (event)
                            {

                                if (
                                    !isStoreOpen()
                                ) {

                                    event.preventDefault();

                                    event.stopPropagation();

                                    openCartStoreClosedModal();

                                }

                            }
                        );

                    }
                );



                /* =========================
                   STORE CLOSED MODAL CLOSE
                ========================== */

                const storeClosedButtons =
                    document.querySelectorAll(
                        '[data-cart-store-closed]'
                    );


                storeClosedButtons.forEach(
                    function (button)
                    {

                        button.addEventListener(
                            'click',
                            function ()
                            {

                                closeCartStoreClosedModal();

                            }
                        );

                    }
                );



                /* =========================
                   ESCAPE KEY
                ========================== */

                document.addEventListener(
                    'keydown',
                    function (event)
                    {

                        if (
                            event.key !== 'Escape'
                        ) {

                            return;

                        }


                        const closedModal =
                            document.getElementById(
                                'fhCartStoreClosedModal'
                            );


                        const clearModal =
                            document.getElementById(
                                'fhClearCartModal'
                            );


                        if (
                            closedModal &&
                            closedModal.classList.contains(
                                'open'
                            )
                        ) {

                            closeCartStoreClosedModal();

                            return;

                        }


                        if (
                            clearModal &&
                            clearModal.classList.contains(
                                'open'
                            )
                        ) {

                            closeClearCartModal();

                            return;

                        }


                        closeCart();

                    }
                );



                /* =========================
                   LOAD CART COUNT
                ========================== */

                fetch(
                    "{{ route('cart.data') }}",
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                )

                    .then(
                        response =>
                            response.json()
                    )

                    .then(
                        data =>
                        {

                            updateCartCount(
                                data.count
                            );

                        }
                    )

                    .catch(
                        () => {

                            // Cart count is optional.

                        }
                    );

            }
        );

    </script>



    {{-- =====================================================
         FOODIEHUB ASSISTANT
    ====================================================== --}}

    <div id="foodiehubAssistant">

        <button
            type="button"
            class="fh-assistant-fab"
            id="fhAssistantOpen"
            aria-label="Open FoodieHub Assistant"
        >

            <span class="fh-fab-icon">
                💬
            </span>

            <span class="fh-fab-text">
                Chat
            </span>

        </button>


        <div
            class="fh-assistant-window"
            id="fhAssistantWindow"
            aria-hidden="true"
        >

            <div class="fh-assistant-header">

                <div class="fh-assistant-profile">

                    <div class="fh-assistant-avatar">
                        🍴
                    </div>


                    <div>

                        <div class="fh-assistant-name">
                            FoodieHub Assistant
                        </div>


                        <div class="fh-assistant-online">

                            <span></span>

                            Online

                        </div>

                    </div>

                </div>


                <button
                    type="button"
                    class="fh-assistant-close"
                    id="fhAssistantClose"
                    aria-label="Close FoodieHub Assistant"
                >
                    ×
                </button>

            </div>



            <div
                class="fh-assistant-body"
                id="fhAssistantBody"
            >

                <div class="fh-message fh-message-bot">

                    <div class="fh-message-bubble">

                        Hi, I'm the FoodieHub assistant.
                        What can I help you with?

                    </div>


                    <div class="fh-message-name">
                        FoodieHub Assistant
                    </div>

                </div>


                <div class="fh-popular-title">
                    POPULAR QUESTIONS
                </div>


                <div class="fh-question-list">

                    <button
                        type="button"
                        class="fh-question"
                        data-question="How long does delivery take?"
                    >
                        How long does delivery take?
                    </button>


                    <button
                        type="button"
                        class="fh-question"
                        data-question="How do I receive my order?"
                    >
                        How do I receive my order?
                    </button>


                    <button
                        type="button"
                        class="fh-question"
                        data-question="Is FoodieHub legit?"
                    >
                        Is FoodieHub legit?
                    </button>


                    <button
                        type="button"
                        class="fh-question"
                        data-question="What payment methods do you accept?"
                    >
                        What payment methods do you accept?
                    </button>


                    <button
                        type="button"
                        class="fh-question"
                        data-question="Do you have promo codes?"
                    >
                        Do you have promo codes?
                    </button>


                    <button
                        type="button"
                        class="fh-question"
                        data-question="I didn't receive my order"
                    >
                        I didn't receive my order
                    </button>

                </div>

            </div>



            <div class="fh-assistant-footer">

                <form
                    class="fh-input-row"
                    id="fhAssistantForm"
                >

                    <input
                        type="text"
                        id="fhAssistantInput"
                        class="fh-assistant-input"
                        placeholder="Type your message..."
                        autocomplete="off"
                    >


                    <button
                        type="submit"
                        class="fh-assistant-send"
                        aria-label="Send message"
                    >
                        ➤
                    </button>

                </form>


                <a
                    href="{{ route('support') }}"
                    class="fh-message-team"
                >
                    Message the team instead
                </a>

            </div>

        </div>

    </div>



    {{-- =====================================================
         ASSISTANT STYLE
    ====================================================== --}}

    <style>

        #foodiehubAssistant {

            position: fixed !important;

            inset: 0 !important;

            width: 100% !important;

            height: 100% !important;

            z-index: 2147483647 !important;

            pointer-events: none !important;

        }


        .fh-assistant-fab {

            position: fixed !important;

            right: 24px !important;

            bottom: 24px !important;

            z-index: 2147483647 !important;

            width: 98px !important;

            height: 46px !important;

            display: flex !important;

            align-items: center !important;

            justify-content: center !important;

            gap: 8px !important;

            padding: 0 !important;

            border: none !important;

            border-radius: 999px !important;

            background: #18c98a !important;

            color: #061009 !important;

            font-family:
                Arial,
                Helvetica,
                sans-serif !important;

            font-size: 14px !important;

            font-weight: 800 !important;

            line-height: 1 !important;

            cursor: pointer !important;

            pointer-events: auto !important;

            box-shadow:
                0 10px 30px
                rgba(
                    0,
                    0,
                    0,
                    .35
                ) !important;

            transition:
                transform .2s ease,
                background .2s ease,
                box-shadow .2s ease !important;

        }


        .fh-assistant-fab:hover {

            background: #22c55e !important;

            transform:
                translateY(-2px) !important;

            box-shadow:
                0 14px 34px
                rgba(
                    0,
                    0,
                    0,
                    .45
                ) !important;

        }


        .fh-fab-icon {

            font-size: 18px !important;

            line-height: 1 !important;

        }


        .fh-fab-text {

            font-size: 14px !important;

            font-weight: 800 !important;

        }


        .fh-assistant-window {

            position: fixed !important;

            right: 24px !important;

            bottom: 24px !important;

            z-index: 2147483647 !important;

            width: 360px !important;

            max-width:
                calc(
                    100vw - 32px
                );

            height: 540px;

            display: flex;

            flex-direction: column;

            overflow: hidden;

            background: #090c0b;

            border: 1px solid #27332c;

            border-radius: 20px;

            box-shadow:
                0 25px 70px
                rgba(
                    0,
                    0,
                    0,
                    .55
                );

            opacity: 0;

            visibility: hidden;

            pointer-events: none;

            transform:
                translateY(20px)
                scale(.97);

            transition:
                opacity .2s ease,
                transform .2s ease,
                visibility .2s ease;

        }


        .fh-assistant-window.open {

            opacity: 1;

            visibility: visible;

            pointer-events: auto;

            transform:
                translateY(0)
                scale(1);

        }


        .fh-assistant-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 16px;

            background: #171c22;

            border-bottom: 1px solid #27332c;

        }


        .fh-assistant-profile {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .fh-assistant-avatar {

            width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #102719;

            border: 1px solid #20b85a;

            font-size: 19px;

        }


        .fh-assistant-name {

            color: #f5f7f6;

            font-size: 14px;

            font-weight: 800;

        }


        .fh-assistant-online {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-top: 2px;

            color: #22c55e;

            font-size: 11px;

        }


        .fh-assistant-online span {

            width: 6px;

            height: 6px;

            border-radius: 50%;

            background: #22c55e;

        }


        .fh-assistant-close {

            width: 30px;

            height: 30px;

            border: none;

            background: transparent;

            color: #8d9691;

            font-size: 25px;

            cursor: pointer;

        }


        .fh-assistant-close:hover {

            color: #fff;

        }


        .fh-assistant-body {

            flex: 1;

            overflow-y: auto;

            padding: 14px 16px 20px;

            background: #090c0b;

        }


        .fh-message {

            display: flex;

            flex-direction: column;

            margin-bottom: 14px;

        }


        .fh-message-user {

            align-items: flex-end;

        }


        .fh-message-bot {

            align-items: flex-start;

        }


        .fh-message-bubble {

            max-width: 84%;

            padding:
                10px
                14px;

            border-radius: 13px;

            font-size: 13px;

            line-height: 1.5;

        }


        .fh-message-bot
        .fh-message-bubble {

            background: #171c22;

            border:
                1px solid
                #242d28;

            color: #f4f6f5;

        }


        .fh-message-user
        .fh-message-bubble {

            background: #0f6f3a;

            border:
                1px solid
                #18a957;

            color: #fff;

        }


        .fh-message-name {

            margin-top: 4px;

            padding-left: 4px;

            color: #22c55e;

            font-size: 10px;

        }


        .fh-popular-title {

            margin:
                16px
                0
                10px;

            text-align: center;

            color: #83908a;

            font-size: 9px;

            letter-spacing: 2px;

        }


        .fh-question-list {

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 7px;

        }


        .fh-question {

            border:
                1px solid
                #29332d;

            border-radius: 999px;

            background: #171c22;

            color: #22c55e;

            padding:
                8px
                15px;

            font-size: 11px;

            cursor: pointer;

            transition: .2s ease;

        }


        .fh-question:hover {

            background:
                rgba(
                    34,
                    197,
                    94,
                    .10
                );

            border-color:
                #22c55e;

            transform:
                translateY(-1px);

        }


        .fh-assistant-footer {

            padding:
                10px
                10px
                12px;

            background: #15191e;

            border-top:
                1px solid
                #26312b;

        }


        .fh-input-row {

            display: flex;

            align-items: center;

            gap: 7px;

        }


        .fh-assistant-input {

            flex: 1;

            min-width: 0;

            height: 46px;

            padding:
                0
                14px;

            border:
                2px solid
                #00d979;

            border-radius: 16px;

            outline: none;

            background: #101418;

            color: #fff;

            font-size: 13px;

        }


        .fh-assistant-input:focus {

            border-color:
                #22c55e;

            box-shadow:
                0 0 0 2px
                rgba(
                    34,
                    197,
                    94,
                    .12
                );

        }


        .fh-assistant-input::placeholder {

            color: #858d89;

        }


        .fh-assistant-send {

            width: 48px;

            height: 46px;

            border: none;

            border-radius: 15px;

            background: #0e6d4c;

            color: #061009;

            font-size: 17px;

            cursor: pointer;

        }


        .fh-assistant-send:hover {

            background:
                #22c55e;

        }


        .fh-message-team {

            display: block;

            margin-top: 5px;

            padding-left: 2px;

            color: #919994;

            font-size: 9px;

            text-decoration: underline;

        }


        .fh-message-team:hover {

            color:
                #22c55e;

        }


        @media (max-width: 600px) {

            .fh-assistant-window {

                right: 8px;

                bottom: 8px;

                width:
                    calc(
                        100vw - 16px
                    );

                height:
                    min(
                        540px,
                        calc(
                            100vh - 16px
                        )
                    );

                border-radius: 16px;

            }


            .fh-assistant-fab {

                right: 16px !important;

                bottom: 16px !important;

                width: 94px !important;

                height: 44px !important;

            }

        }

    </style>



    {{-- =====================================================
         ASSISTANT JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function ()
            {

                const openButton =
                    document.getElementById(
                        'fhAssistantOpen'
                    );


                const windowEl =
                    document.getElementById(
                        'fhAssistantWindow'
                    );


                const closeButton =
                    document.getElementById(
                        'fhAssistantClose'
                    );


                const form =
                    document.getElementById(
                        'fhAssistantForm'
                    );


                const input =
                    document.getElementById(
                        'fhAssistantInput'
                    );


                const body =
                    document.getElementById(
                        'fhAssistantBody'
                    );


                if (
                    !openButton ||
                    !windowEl ||
                    !closeButton ||
                    !form ||
                    !input ||
                    !body
                ) {

                    return;

                }


                function openAssistant()
                {

                    windowEl.classList.add(
                        'open'
                    );


                    windowEl.setAttribute(
                        'aria-hidden',
                        'false'
                    );


                    openButton.style.display =
                        'none';


                    setTimeout(
                        () => input.focus(),
                        100
                    );

                }


                function closeAssistant()
                {

                    windowEl.classList.remove(
                        'open'
                    );


                    windowEl.setAttribute(
                        'aria-hidden',
                        'true'
                    );


                    openButton.style.display =
                        'flex';

                }


                function botReply(
                    message
                )
                {

                    const text =
                        message
                            .toLowerCase()
                            .trim();


                    if (
                        text.includes('delivery') &&
                        (
                            text.includes(
                                'how long'
                            ) ||
                            text.includes(
                                'time'
                            ) ||
                            text.includes(
                                'take'
                            )
                        )
                    ) {

                        return 'Delivery time depends on order preparation, your location, and driver availability. You can check your current order status from <strong>My Orders</strong>.';

                    }


                    if (
                        text.includes('receive') &&
                        text.includes('order')
                    ) {

                        return 'Your order will be delivered to the address you entered during checkout. Please keep your phone available in case the driver needs to contact you.';

                    }


                    if (
                        text.includes('legit') ||
                        text.includes('legitimate')
                    ) {

                        return 'Yes. FoodieHub is our food ordering management system made to make ordering, delivery, and order tracking easier.';

                    }


                    if (
                        text.includes('payment') ||
                        text.includes('gcash') ||
                        text.includes('cash')
                    ) {

                        return 'FoodieHub currently supports <strong>Cash on Delivery</strong> and <strong>GCash</strong> during checkout.';

                    }


                    if (
                        text.includes('promo') ||
                        text.includes('discount') ||
                        text.includes('coupon')
                    ) {

                        return 'Promo codes are not currently available. Keep an eye on FoodieHub announcements for future promotions.';

                    }


                    if (
                        text.includes(
                            "didn't receive"
                        ) ||
                        text.includes(
                            'did not receive'
                        ) ||
                        text.includes(
                            'not receive'
                        ) ||
                        text.includes(
                            'where is my order'
                        ) ||
                        text.includes(
                            'missing order'
                        )
                    ) {

                        return 'Please open <strong>My Orders</strong> and check your latest order status. If there is still a problem, use the FoodieHub support page to contact the team.';

                    }


                    if (
                        text.includes(
                            'cancel'
                        )
                    ) {

                        return 'Order cancellation depends on the current order status. Open your order details or contact FoodieHub support for help.';

                    }


                    if (
                        text.includes(
                            'track'
                        ) ||
                        text.includes(
                            'status'
                        )
                    ) {

                        return 'You can track your order by opening <strong>My Orders</strong>. Your current order status is shown there.';

                    }


                    if (
                        text.includes(
                            'hello'
                        ) ||
                        text.includes(
                            'hi'
                        ) ||
                        text.includes(
                            'hey'
                        )
                    ) {

                        return "Hi! 👋 I'm the FoodieHub Assistant. Ask me about delivery, payments, order tracking, or cancellations.";

                    }


                    return 'I can help with <strong>delivery</strong>, <strong>payments</strong>, <strong>order tracking</strong>, and <strong>cancellations</strong>. Try asking one of those.';

                }


                function addMessage(
                    message,
                    type
                )
                {

                    const wrapper =
                        document.createElement(
                            'div'
                        );


                    wrapper.className =
                        type === 'user'
                            ? 'fh-message fh-message-user'
                            : 'fh-message fh-message-bot';


                    const bubble =
                        document.createElement(
                            'div'
                        );


                    bubble.className =
                        'fh-message-bubble';


                    bubble.innerHTML =
                        message;


                    wrapper.appendChild(
                        bubble
                    );


                    if (
                        type === 'bot'
                    ) {

                        const name =
                            document.createElement(
                                'div'
                            );


                        name.className =
                            'fh-message-name';


                        name.textContent =
                            'FoodieHub Assistant';


                        wrapper.appendChild(
                            name
                        );

                    }


                    body.appendChild(
                        wrapper
                    );


                    body.scrollTop =
                        body.scrollHeight;

                }


                form.addEventListener(
                    'submit',
                    function (event)
                    {

                        event.preventDefault();


                        const message =
                            input.value.trim();


                        if (!message) {

                            return;

                        }


                        addMessage(
                            escapeHtml(
                                message
                            ),
                            'user'
                        );


                        input.value =
                            '';


                        setTimeout(
                            function ()
                            {

                                addMessage(
                                    botReply(
                                        message
                                    ),
                                    'bot'
                                );

                            },
                            450
                        );

                    }
                );


                document
                    .querySelectorAll(
                        '.fh-question'
                    )
                    .forEach(
                        function (button)
                        {

                            button.addEventListener(
                                'click',
                                function ()
                                {

                                    input.value =
                                        button.dataset.question ||
                                        '';


                                    form.requestSubmit();

                                }
                            );

                        }
                    );


                openButton.addEventListener(
                    'click',
                    openAssistant
                );


                closeButton.addEventListener(
                    'click',
                    closeAssistant
                );


                document.addEventListener(
                    'keydown',
                    function (event)
                    {

                        if (
                            event.key ===
                            'Escape'
                        ) {

                            closeAssistant();

                        }

                    }
                );


                function escapeHtml(
                    value
                )
                {

                    const div =
                        document.createElement(
                            'div'
                        );


                    div.textContent =
                        value;


                    return div.innerHTML;

                }

            }
        );

    </script>



    {{-- =====================================================
         CLEAR CART + STORE CLOSED MODAL STYLE
    ====================================================== --}}

    <style>

        .fh-clear-cart-modal {

            position: fixed;

            inset: 0;

            z-index: 2147483000;

            display: none;

            align-items: center;

            justify-content: center;

            padding: 20px;

            box-sizing: border-box;

        }


        .fh-clear-cart-modal.open {

            display: flex;

        }


        .fh-clear-cart-overlay {

            position: absolute;

            inset: 0;

            background:
                rgba(
                    0,
                    0,
                    0,
                    0.78
                );

        }


        .fh-clear-cart-box {

            position: relative;

            z-index: 1;

            width:
                min(
                    430px,
                    100%
                );

            box-sizing: border-box;

            padding: 30px;

            background:
                #111512;

            border:
                1px solid
                #3c2a2d;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 25px 70px
                rgba(
                    0,
                    0,
                    0,
                    0.55
                );

        }


        .fh-clear-cart-icon {

            width: 58px;

            height: 58px;

            margin:
                0
                auto
                17px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 16px;

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.10
                );

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    0.22
                );

            font-size: 27px;

        }


        .fh-clear-cart-box h2 {

            margin:
                0
                0
                10px;

            color:
                #ffffff;

            font-size: 22px;

            font-weight: 800;

        }


        .fh-clear-cart-box p {

            max-width: 340px;

            margin:
                0
                auto
                12px;

            color:
                #a7b0aa;

            font-size: 14px;

            line-height: 1.6;

        }


        .fh-clear-cart-warning {

            display: block;

            color:
                #f87171;

            font-size: 11px;

            font-weight: 700;

            line-height: 1.5;

        }


        .fh-clear-cart-actions {

            display: flex;

            gap: 10px;

            margin-top: 25px;

        }


        .fh-clear-cart-cancel,
        .fh-clear-cart-confirm {

            flex: 1;

            min-height: 46px;

            border-radius: 11px;

            font-size: 13px;

            font-weight: 800;

            cursor: pointer;

        }


        .fh-clear-cart-cancel {

            border:
                1px solid
                #344038;

            background:
                #0d100e;

            color:
                #ffffff;

        }


        .fh-clear-cart-cancel:hover {

            background:
                #151a17;

        }


        .fh-clear-cart-confirm {

            border:
                1px solid
                #dc2626;

            background:
                #dc2626;

            color:
                #ffffff;

        }


        .fh-clear-cart-confirm:hover {

            background:
                #b91c1c;

            border-color:
                #b91c1c;

        }


        .fh-clear-cart-confirm:disabled {

            opacity: 0.6;

            cursor:
                not-allowed;

        }



        /* =====================================================
           STORE CLOSED MODAL
        ====================================================== */

        .fh-cart-store-closed-modal {

            position: fixed;

            inset: 0;

            z-index: 2147483000;

            display: none;

            align-items: center;

            justify-content: center;

            padding: 20px;

            box-sizing: border-box;

        }


        .fh-cart-store-closed-modal.open {

            display: flex;

        }


        .fh-cart-store-closed-overlay {

            position: absolute;

            inset: 0;

            background:
                rgba(
                    0,
                    0,
                    0,
                    0.78
                );

        }


        .fh-cart-store-closed-box {

            position: relative;

            z-index: 1;

            width:
                min(
                    430px,
                    100%
                );

            padding: 30px;

            box-sizing: border-box;

            background:
                #111512;

            border:
                1px solid
                #4b2929;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 25px 70px
                rgba(
                    0,
                    0,
                    0,
                    0.55
                );

        }


        .fh-cart-store-closed-icon {

            width: 62px;

            height: 62px;

            margin:
                0
                auto
                17px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 17px;

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.10
                );

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    0.22
                );

            font-size: 28px;

        }


        .fh-cart-store-closed-label {

            display: block;

            margin-bottom: 7px;

            color:
                #f87171;

            font-size: 11px;

            font-weight: 800;

            letter-spacing:
                0.10em;

        }


        .fh-cart-store-closed-box h2 {

            margin:
                0
                0
                10px;

            color:
                #ffffff;

            font-size: 23px;

            font-weight: 800;

        }


        .fh-cart-store-closed-box p {

            max-width: 340px;

            margin:
                0
                auto;

            color:
                #9ca6a0;

            font-size: 13px;

            line-height: 1.7;

        }


        .fh-cart-store-closed-button {

            width: 100%;

            min-height: 46px;

            margin-top: 24px;

            border:
                1px solid
                #344038;

            border-radius: 11px;

            background:
                #0d100e;

            color:
                #ffffff;

            font-size: 13px;

            font-weight: 800;

            cursor: pointer;

        }


        .fh-cart-store-closed-button:hover {

            background:
                #171c18;

            border-color:
                #4a574f;

        }



        @media (max-width: 600px) {

            .fh-clear-cart-box {

                padding:
                    26px 20px;

                border-radius:
                    18px;

            }


            .fh-clear-cart-actions {

                flex-direction:
                    column;

            }


            .fh-clear-cart-cancel,
            .fh-clear-cart-confirm {

                width: 100%;

            }


            .fh-cart-store-closed-box {

                padding:
                    26px 20px;

                border-radius:
                    18px;

            }

        }

    </style>



    {{-- =====================================================
         RESPONSIVE NAVIGATION
         Compact two-column mobile menu; desktop navigation stays horizontal.
    ====================================================== --}}
    <style>
        .site-header .navbar {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .fh-navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            flex: 0 0 auto;
            color: #fff;
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.1;
            text-decoration: none;
            white-space: nowrap;
        }

        .fh-navbar-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .site-header .mobile-menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            padding: 0;
            border: 1px solid #294033;
            border-radius: 10px;
            background: #111713;
            color: #fff;
            cursor: pointer;
        }

        .site-header .mobile-menu-toggle span {
            display: block;
            width: 21px;
            height: 2px;
            border-radius: 2px;
            background: currentColor;
            transition: transform .18s ease, opacity .18s ease;
        }

        .site-header .mobile-menu-toggle.is-open span:first-child {
            transform: translateY(7px) rotate(45deg);
        }

        .site-header .mobile-menu-toggle.is-open span:nth-child(2) {
            opacity: 0;
        }

        .site-header .mobile-menu-toggle.is-open span:last-child {
            transform: translateY(-7px) rotate(-45deg);
        }

        @media (max-width: 767px) {
            .site-header .navbar {
                min-height: 66px;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .site-header .fh-navbar-brand {
                font-size: 23px;
            }

            .site-header .mobile-menu-toggle {
                display: inline-flex;
                margin-left: auto;
            }

            /* High-specificity display rules stop old .nav styles forcing this open. */
            .site-header .fh-main-navigation:not(.is-open) {
                display: none !important;
            }

            .site-header .fh-main-navigation.is-open {
                position: absolute !important;
                top: calc(100% + 8px) !important;
                right: 0 !important;
                left: auto !important;
                z-index: 1200 !important;
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                align-items: stretch !important;
                justify-content: stretch !important;
                gap: 8px !important;
                width: min(360px, calc(100vw - 24px)) !important;
                max-height: min(65dvh, 520px) !important;
                overflow-x: hidden !important;
                overflow-y: auto !important;
                box-sizing: border-box !important;
                margin: 0 !important;
                padding: 12px !important;
                border: 1px solid #294033 !important;
                border-radius: 14px !important;
                background: #090c0a !important;
                box-shadow: 0 18px 45px rgba(0, 0, 0, .55) !important;
            }

            .site-header .fh-main-navigation > a,
            .site-header .fh-main-navigation > button,
            .site-header .fh-main-navigation > form,
            .site-header .fh-main-navigation > .user-name {
                box-sizing: border-box !important;
                min-width: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
            }

            .site-header .fh-main-navigation > .fh-nav-link,
            .site-header .fh-main-navigation > .login-link,
            .site-header .fh-main-navigation > .admin-nav-link,
            .site-header .fh-main-navigation > .register-button,
            .site-header .fh-main-navigation > .nav-cart-button {
                display: flex !important;
                min-height: 44px !important;
                justify-content: flex-start !important;
                white-space: normal !important;
                text-align: left !important;
                padding: 10px !important;
                overflow-wrap: anywhere;
            }

            .site-header .fh-main-navigation > .user-name {
                grid-column: 1 / -1;
                padding: 8px 10px !important;
                color: #b9c3bc !important;
                font-size: 13px !important;
                overflow-wrap: anywhere;
            }

            .site-header .fh-main-navigation > form {
                display: flex !important;
            }

            .site-header .fh-main-navigation > form .logout-button {
                width: 100% !important;
                min-height: 44px !important;
                text-align: left !important;
                justify-content: flex-start !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .site-header .mobile-menu-toggle span {
                transition: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('mobileMenuToggle');
            const navigation = document.getElementById('mainNavigation');
            const mobileQuery = window.matchMedia('(max-width: 767px)');

            if (!menuButton || !navigation) {
                return;
            }

            function setMenuOpen(open) {
                const shouldOpen = Boolean(open && mobileQuery.matches);

                navigation.classList.toggle('is-open', shouldOpen);
                menuButton.classList.toggle('is-open', shouldOpen);
                menuButton.setAttribute('aria-expanded', String(shouldOpen));
                menuButton.setAttribute(
                    'aria-label',
                    shouldOpen ? 'Close navigation menu' : 'Open navigation menu'
                );
                navigation.setAttribute(
                    'aria-hidden',
                    String(mobileQuery.matches && !shouldOpen)
                );
            }

            menuButton.addEventListener('click', function (event) {
                event.preventDefault();
                setMenuOpen(!navigation.classList.contains('is-open'));
            });

            // Close after selecting any menu item, including the Cart button.
            navigation.addEventListener('click', function (event) {
                const control = event.target.closest('a, button');
                if (control && navigation.contains(control)) {
                    setMenuOpen(false);
                }
            });

            // Close when a logout form is submitted.
            navigation.addEventListener('submit', function () {
                setMenuOpen(false);
            });

            // Close when the user taps/clicks outside the menu.
            document.addEventListener('click', function (event) {
                if (
                    navigation.classList.contains('is-open') &&
                    !navigation.contains(event.target) &&
                    !menuButton.contains(event.target)
                ) {
                    setMenuOpen(false);
                }
            });

            // Escape closes the menu; preserve expected keyboard behavior.
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && navigation.classList.contains('is-open')) {
                    setMenuOpen(false);
                    menuButton.focus();
                }
            });

            // Always reset menu state when switching between mobile and desktop.
            function handleBreakpointChange() {
                setMenuOpen(false);
            }

            if (typeof mobileQuery.addEventListener === 'function') {
                mobileQuery.addEventListener('change', handleBreakpointChange);
            } else if (typeof mobileQuery.addListener === 'function') {
                mobileQuery.addListener(handleBreakpointChange);
            }

            setMenuOpen(false);
        });
    </script>

</body>

</html>