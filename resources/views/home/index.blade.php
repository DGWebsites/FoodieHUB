@extends('layouts.app')

@section('content')

@php

    $storeSetting = \App\Models\StoreSetting::first();

    $storeIsOpen = $storeSetting
        ? $storeSetting->is_open
        : true;

@endphp


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

            <a
                href="#products"
                class="primary-button"
            >
                Explore Menu
            </a>

        </div>


        <div class="hero-card">

            <div class="hero-card-icon">
                🍔
            </div>

            <h3>
                Hungry?
            </h3>

            <p>
                Your next meal is just a few clicks away.
            </p>

        </div>

    </div>

</section>



<section class="food-dashboard">

    <div class="container">

        {{-- SEARCH --}}

        <form
            method="GET"
            action="{{ route('home') }}"
            class="food-search"
        >

            <span class="search-icon">
                🔎
            </span>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search food..."
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
                    class="category-button"
                >
                    🍽️ All
                </a>


                @foreach ($categories as $category)

                    <a
                        href="{{ route(
                            'home',
                            ['category' => $category->id]
                        ) }}"
                        class="category-button"
                    >
                        {{ $category->name }}
                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>



<section
    class="products-section"
    id="products"
>

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


                        {{-- =================================================
                             PRODUCT IMAGE
                             NOT CLICKABLE
                        ================================================== --}}

                        <div class="product-image">

                            @if ($product->image)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $product->image
                                    ) }}"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <div class="image-placeholder">
                                    🍽️
                                </div>

                            @endif

                        </div>



                        {{-- =================================================
                             PRODUCT INFORMATION
                        ================================================== --}}

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
                                    ₱{{ number_format(
                                        $product->price,
                                        2
                                    ) }}
                                </strong>

                            </div>



                            {{-- =================================================
                                 PRODUCT ACTIONS
                            ================================================== --}}

                            <div class="product-actions">


                                {{-- ADD TO CART --}}

                                <button
                                    type="button"
                                    class="cart-button"
                                    data-product-id="{{ $product->id }}"
                                    data-action="cart"
                                >
                                    🛒 Cart
                                </button>



                                {{-- BUY NOW --}}

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



{{-- =============================================================
     STORE CLOSED MODAL
============================================================= --}}

<div
    id="fhStoreClosedModal"
    class="fh-store-closed-modal"
    aria-hidden="true"
>

    {{-- OVERLAY --}}

    <div
        class="fh-store-closed-overlay"
        data-store-closed-cancel
    >
    </div>


    {{-- MODAL BOX --}}

    <div
        class="fh-store-closed-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="fhStoreClosedTitle"
    >

        {{-- ICON --}}

        <div class="fh-store-closed-icon">
            🔴
        </div>


        {{-- LABEL --}}

        <span class="fh-store-closed-label">
            STORE STATUS
        </span>


        {{-- TITLE --}}

        <h2 id="fhStoreClosedTitle">
            FoodieHub is Closed
        </h2>


        {{-- MESSAGE --}}

        <p>
            We're currently not accepting new orders.
            Please check back later when the store is open.
        </p>


        {{-- BUTTON --}}

        <button
            type="button"
            class="fh-store-closed-button"
            data-store-closed-cancel
        >
            Got It
        </button>

    </div>

</div>



{{-- =============================================================
     STORE STATUS DATA
============================================================= --}}

<div
    id="fhStoreStatusData"
    data-store-open="{{ $storeIsOpen ? '1' : '0' }}"
    hidden
>
</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | STORE STATUS
    |--------------------------------------------------------------------------
    */

    const storeStatusData =
        document.getElementById(
            'fhStoreStatusData'
        );

    const storeIsOpen =
        storeStatusData
        && storeStatusData.dataset.storeOpen === '1';



    /*
    |--------------------------------------------------------------------------
    | PRODUCT BUTTONS
    |--------------------------------------------------------------------------
    */

    const cartButtons =
        document.querySelectorAll(
            '[data-action="cart"]'
        );

    const buyButtons =
        document.querySelectorAll(
            '[data-action="buy"]'
        );



    /*
    |--------------------------------------------------------------------------
    | STORE CLOSED MODAL
    |--------------------------------------------------------------------------
    */

    const storeClosedModal =
        document.getElementById(
            'fhStoreClosedModal'
        );

    const closeButtons =
        document.querySelectorAll(
            '[data-store-closed-cancel]'
        );



    /*
    |--------------------------------------------------------------------------
    | OPEN STORE CLOSED MODAL
    |--------------------------------------------------------------------------
    */

    function openStoreClosedModal()
    {
        if (!storeClosedModal) {
            return;
        }

        storeClosedModal.classList.add(
            'open'
        );

        storeClosedModal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow =
            'hidden';
    }



    /*
    |--------------------------------------------------------------------------
    | CLOSE STORE CLOSED MODAL
    |--------------------------------------------------------------------------
    */

    function closeStoreClosedModal()
    {
        if (!storeClosedModal) {
            return;
        }

        storeClosedModal.classList.remove(
            'open'
        );

        storeClosedModal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow =
            '';
    }



    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */

    cartButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const productId =
                    this.dataset.productId;

                if (
                    typeof window.addToCart ===
                        'function'
                    && productId
                ) {

                    window.addToCart(
                        productId
                    );

                }

            }
        );

    });



    /*
    |--------------------------------------------------------------------------
    | BUY NOW
    |--------------------------------------------------------------------------
    */

    buyButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const productId =
                    this.dataset.productId;


                /*
                |--------------------------------------------------------------------------
                | STORE CLOSED
                |--------------------------------------------------------------------------
                */

                if (!storeIsOpen) {

                    openStoreClosedModal();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | STORE LIVE
                |--------------------------------------------------------------------------
                */

                if (
                    typeof window.buyNow ===
                        'function'
                    && productId
                ) {

                    window.buyNow(
                        productId
                    );

                }

            }
        );

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
    | ESC KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape'
                && storeClosedModal
                && storeClosedModal.classList.contains(
                    'open'
                )
            ) {

                closeStoreClosedModal();

            }

        }
    );

});

</script>



<style>

/* =========================================================
   STORE CLOSED MODAL
========================================================= */

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


/* =========================================================
   OVERLAY
========================================================= */

.fh-store-closed-overlay {

    position: absolute;

    inset: 0;

    background: rgba(
        0,
        0,
        0,
        0.78
    );

}


/* =========================================================
   MODAL BOX
========================================================= */

.fh-store-closed-box {

    position: relative;

    z-index: 1;

    width: min(
        430px,
        100%
    );

    padding: 30px;

    box-sizing: border-box;

    background: #111512;

    border: 1px solid #4b2929;

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


/* =========================================================
   ICON
========================================================= */

.fh-store-closed-icon {

    width: 62px;

    height: 62px;

    margin: 0 auto 17px;

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


/* =========================================================
   LABEL
========================================================= */

.fh-store-closed-label {

    display: block;

    margin-bottom: 7px;

    color: #f87171;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 0.10em;

}


/* =========================================================
   TITLE
========================================================= */

.fh-store-closed-box h2 {

    margin:
        0
        0
        10px;

    color: #ffffff;

    font-size: 23px;

    font-weight: 800;

}


/* =========================================================
   MESSAGE
========================================================= */

.fh-store-closed-box p {

    max-width: 340px;

    margin:
        0
        auto;

    color: #9ca6a0;

    font-size: 13px;

    line-height: 1.7;

}


/* =========================================================
   BUTTON
========================================================= */

.fh-store-closed-button {

    width: 100%;

    min-height: 46px;

    margin-top: 24px;

    border:
        1px solid
        #344038;

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


/* =========================================================
   IMAGE IS NOT CLICKABLE
========================================================= */

.product-image {

    cursor: default;

}

.product-image img {

    cursor: default;

}

</style>

@endsection