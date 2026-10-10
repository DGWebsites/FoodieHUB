
@extends('layouts.app')

@section('content')

@php
    $storeSetting = \App\Models\StoreSetting::first();

    $storeIsOpen = $storeSetting
        ? $storeSetting->is_open
        : true;
@endphp

{{-- =========================================================
     HERO SECTION
========================================================= --}}

<section class="hero">
    <div class="container hero-content">

        <div class="hero-text">

            <span class="hero-label">
                Fresh • Fast • Delicious
            </span>

            <h1>
                Your favorite food,
                <span>delivered.</span>
            </h1>

            <p>
                Discover delicious meals, choose your favorites,
                and order everything with just a few clicks.
            </p>

            <a href="#products" class="primary-button">
                Explore Menu
            </a>

        </div>

        {{-- CARTOON FOOD IMAGE --}}

        <div class="hero-visual">
           <img
    src="{{ asset('images/background.png') }}"
    alt="FoodieHub cartoon food illustration"
    class="hero-food-image"
>
        </div>

    </div>
</section>

{{-- =========================================================
     FOOD SEARCH AND CATEGORIES
========================================================= --}}

<section class="food-dashboard">
    <div class="container">

        {{-- SEARCH --}}

        <form
            method="GET"
            action="{{ route('home') }}"
            class="food-search"
        >
            <span class="search-icon">🔎</span>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search food..."
                aria-label="Search food"
            >

            <button type="submit">
                Search
            </button>
        </form>

        {{-- CATEGORIES --}}

        <div class="category-section">

            <span class="category-title">
                Categories:
            </span>

            <div class="category-list">

                <a
                    href="{{ route('home') }}"
                    class="category-button {{ !request('category') ? 'active' : '' }}"
                >
                    🍽️ All
                </a>

                @foreach ($categories as $category)

                    <a
                        href="{{ route('home', ['category' => $category->id]) }}"
                        class="category-button {{ (string) request('category') === (string) $category->id ? 'active' : '' }}"
                    >
                        {{ $category->name }}
                    </a>

                @endforeach

            </div>
        </div>

    </div>
</section>

{{-- =========================================================
     PRODUCTS SECTION
========================================================= --}}

<section class="products-section" id="products">
    <div class="container">

        {{-- SECTION HEADER --}}

        <div class="section-heading">

            <div>
                <span class="section-label">
                    OUR MENU
                </span>

                <h2>
                    Popular Food
                </h2>
            </div>

            <p>
                Fresh meals made for every craving.
            </p>

        </div>

        {{-- EMPTY STATE --}}

        @if ($products->isEmpty())

            <div class="empty-state">

                <div class="empty-icon">
                    🍽️
                </div>

                <h3>
                    No food found
                </h3>

                <p>
                    Try searching for something else.
                </p>

            </div>

        @else

            {{-- PRODUCT GRID --}}

            <div class="product-grid">

                @foreach ($products as $product)

                    <article class="product-card">

                        {{-- PRODUCT IMAGE --}}

                        <div class="product-image">

                            @if ($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="image-placeholder">
                                    🍽️
                                </div>

                            @endif

                        </div>

                        {{-- PRODUCT INFORMATION --}}

                        <div class="product-info">

                            {{-- CATEGORY --}}

                            @if ($product->category)

                                <span class="product-category">
                                    {{ $product->category->name }}
                                </span>

                            @endif

                            {{-- NAME --}}

                            <h3>
                                {{ $product->name }}
                            </h3>

                            {{-- DESCRIPTION --}}

                            @if ($product->description)

                                <p>
                                    {{ $product->description }}
                                </p>

                            @endif

                            {{-- PRICE --}}

                            <div class="product-bottom">

                                <strong>
                                    ₱{{ number_format($product->price, 2) }}
                                </strong>

                            </div>

                            {{-- PRODUCT ACTIONS --}}

                            <div class="product-actions">

                                <button
                                    type="button"
                                    class="cart-button"
                                    data-product-id="{{ $product->id }}"
                                    data-action="cart"
                                >
                                    🛒 Cart
                                </button>

                                <button
                                    type="button"
                                    class="buy-button"
                                    data-product-id="{{ $product->id }}"
                                    data-action="buy"
                                >
                                    ⚡ Buy Now
                                </button>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>
</section>

{{-- =========================================================
     STORE CLOSED MODAL
========================================================= --}}

<div
    id="fhStoreClosedModal"
    class="fh-store-closed-modal"
    aria-hidden="true"
>

    {{-- OVERLAY --}}

    <div
        class="fh-store-closed-overlay"
        data-store-closed-cancel
    ></div>

    {{-- MODAL BOX --}}

    <div
        class="fh-store-closed-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="fhStoreClosedTitle"
    >

        <div class="fh-store-closed-icon">
            🔴
        </div>

        <span class="fh-store-closed-label">
            STORE STATUS
        </span>

        <h2 id="fhStoreClosedTitle">
            FoodieHub is Closed
        </h2>

        <p>
            We're currently not accepting new orders.
            Please check back later when the store is open.
        </p>

        <button
            type="button"
            class="fh-store-closed-button"
            data-store-closed-cancel
        >
            Got It
        </button>

    </div>

</div>

{{-- =========================================================
     STORE STATUS DATA
========================================================= --}}

<div
    id="fhStoreStatusData"
    data-store-open="{{ $storeIsOpen ? '1' : '0' }}"
    hidden
></div>

{{-- =========================================================
     PRODUCT AND STORE MODAL JAVASCRIPT
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | STORE STATUS
    |--------------------------------------------------------------------------
    */

    const storeStatusData = document.getElementById(
        'fhStoreStatusData'
    );

    const storeIsOpen = storeStatusData
        && storeStatusData.dataset.storeOpen === '1';

    /*
    |--------------------------------------------------------------------------
    | PRODUCT BUTTONS
    |--------------------------------------------------------------------------
    */

    const cartButtons = document.querySelectorAll(
        '[data-action="cart"]'
    );

    const buyButtons = document.querySelectorAll(
        '[data-action="buy"]'
    );

    /*
    |--------------------------------------------------------------------------
    | STORE CLOSED MODAL
    |--------------------------------------------------------------------------
    */

    const storeClosedModal = document.getElementById(
        'fhStoreClosedModal'
    );

    const closeButtons = document.querySelectorAll(
        '[data-store-closed-cancel]'
    );

    function openStoreClosedModal() {
        if (!storeClosedModal) {
            return;
        }

        storeClosedModal.classList.add('open');

        storeClosedModal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';
    }

    function closeStoreClosedModal() {
        if (!storeClosedModal) {
            return;
        }

        storeClosedModal.classList.remove('open');

        storeClosedModal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';
    }

    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    cartButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId = this.dataset.productId;

            if (
                typeof window.addToCart === 'function'
                && productId
            ) {
                window.addToCart(productId);
            }

        });

    });

    /*
    |--------------------------------------------------------------------------
    | BUY NOW
    |--------------------------------------------------------------------------
    */

    buyButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId = this.dataset.productId;

            if (!storeIsOpen) {
                openStoreClosedModal();
                return;
            }

            if (
                typeof window.buyNow === 'function'
                && productId
            ) {
                window.buyNow(productId);
            }

        });

    });

    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL BUTTONS
    |--------------------------------------------------------------------------
    */

    closeButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            closeStoreClosedModal
        );

    });

    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape'
            && storeClosedModal
            && storeClosedModal.classList.contains('open')
        ) {
            closeStoreClosedModal();
        }

    });

});
</script>

{{-- =========================================================
     STORE CLOSED MODAL STYLES
========================================================= --}}

<style>
.fh-store-closed-modal {
    position: fixed;
    inset: 0;
    z-index: 2147483000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

.fh-store-closed-modal.open {
    display: flex;
}

.fh-store-closed-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.78);
}

.fh-store-closed-box {
    position: relative;
    z-index: 1;
    width: min(430px, 100%);
    padding: 30px;
    box-sizing: border-box;
    background: #111512;
    border: 1px solid #4b2929;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.55);
}

.fh-store-closed-icon {
    width: 62px;
    height: 62px;
    margin: 0 auto 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 17px;
    background: rgba(239, 68, 68, 0.10);
    border: 1px solid rgba(239, 68, 68, 0.22);
    font-size: 28px;
}

.fh-store-closed-label {
    display: block;
    margin-bottom: 7px;
    color: #f87171;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.10em;
}

.fh-store-closed-box h2 {
    margin: 0 0 10px;
    color: #ffffff;
    font-size: 23px;
    font-weight: 800;
}

.fh-store-closed-box p {
    max-width: 340px;
    margin: 0 auto;
    color: #9ca6a0;
    font-size: 13px;
    line-height: 1.7;
}

.fh-store-closed-button {
    width: 100%;
    min-height: 46px;
    margin-top: 24px;
    border: 1px solid #344038;
    border-radius: 11px;
    background: #0d100e;
    color: #ffffff;
    font-size: 13px;
    font-weight: 800;
    cursor: pointer;
}

.fh-store-closed-button:hover {
    background: #171c18;
    border-color: #4a574f;
}

/* Product images remain non-clickable. */
.product-image,
.product-image img {
    cursor: default;
}
</style>

@endsection
