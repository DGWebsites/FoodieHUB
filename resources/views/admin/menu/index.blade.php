@extends('layouts.app')

@section('content')

<section class="fh-admin-menu-section">

    <div class="fh-admin-menu-container">


        {{-- =====================================================
             BACK BUTTON
        ====================================================== --}}

        <a
            href="{{ route('admin.dashboard') }}"
            class="fh-admin-menu-back"
        >
            ← Back to Dashboard
        </a>


        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div class="fh-admin-menu-message success">

                <span>
                    ✓
                </span>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- =====================================================
             ERROR MESSAGE
        ====================================================== --}}

        @if(session('error'))

            <div class="fh-admin-menu-message error">

                <span>
                    !
                </span>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="fh-admin-menu-header">

            <div>

                <span class="fh-admin-menu-label">
                    ADMIN PANEL
                </span>

                <h1>
                    Menu Management
                </h1>

                <p>
                    Add, view, edit, and delete food items from the
                    FoodieHub menu available to customers.
                </p>

            </div>


            <a
                href="{{ route('admin.menu.create') }}"
                class="fh-admin-menu-add-button"
            >

                <span>
                    +
                </span>

                Add Menu Item

            </a>

        </div>


        {{-- =====================================================
             MENU SUMMARY
        ====================================================== --}}

        <div class="fh-admin-menu-summary">


            {{-- TOTAL --}}

            <div class="fh-admin-menu-summary-card">

                <div class="fh-admin-menu-summary-icon">
                    🍽️
                </div>

                <div>

                    <span>
                        Total Menu Items
                    </span>

                    <strong>
                        {{ number_format($products->count()) }}
                    </strong>

                </div>

            </div>


            {{-- AVAILABLE --}}

            <div class="fh-admin-menu-summary-card">

                <div class="fh-admin-menu-summary-icon">
                    🟢
                </div>

                <div>

                    <span>
                        Available
                    </span>

                    <strong>
                        {{ number_format(
                            $products
                                ->where('is_available', true)
                                ->count()
                        ) }}
                    </strong>

                </div>

            </div>


            {{-- UNAVAILABLE --}}

            <div class="fh-admin-menu-summary-card">

                <div class="fh-admin-menu-summary-icon">
                    ⚫
                </div>

                <div>

                    <span>
                        Unavailable
                    </span>

                    <strong>
                        {{ number_format(
                            $products
                                ->where('is_available', false)
                                ->count()
                        ) }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =====================================================
             MENU PANEL
        ====================================================== --}}

        <div class="fh-admin-menu-panel">


            {{-- PANEL HEADER --}}

            <div class="fh-admin-menu-panel-header">

                <div>

                    <span class="fh-admin-menu-label">
                        FOOD MENU
                    </span>

                    <h2>
                        Menu Items
                    </h2>

                </div>


                <span class="fh-admin-menu-count">

                    {{ $products->count() }}

                    {{ $products->count() === 1
                        ? 'Item'
                        : 'Items' }}

                </span>

            </div>


            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            @if($products->isEmpty())

                <div class="fh-admin-menu-empty">

                    <div class="fh-admin-menu-empty-icon">
                        🍽️
                    </div>

                    <h3>
                        No Menu Items Yet
                    </h3>

                    <p>
                        Start building your FoodieHub menu by
                        adding your first food item.
                    </p>

                    <a
                        href="{{ route('admin.menu.create') }}"
                        class="fh-admin-menu-add-button"
                    >

                        <span>
                            +
                        </span>

                        Add First Menu Item

                    </a>

                </div>


            @else


                {{-- =================================================
                     MENU ITEMS
                ================================================== --}}

                <div class="fh-admin-menu-list">


                    @foreach($products as $product)

                        <div class="fh-admin-menu-item">


                            {{-- FOOD IMAGE --}}

                            <div class="fh-admin-menu-image">

                                @if($product->image)

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $product->image
                                        ) }}"
                                        alt="{{ $product->name }}"
                                    >

                                @else

                                    <span>
                                        🍽️
                                    </span>

                                @endif

                            </div>


                            {{-- FOOD INFO --}}

                            <div class="fh-admin-menu-info">

                                <span class="fh-admin-menu-category">

                                    {{ $product->category?->name
                                        ?? 'No Category' }}

                                </span>

                                <h3>
                                    {{ $product->name }}
                                </h3>


                                @if($product->description)

                                    <p>
                                        {{ $product->description }}
                                    </p>

                                @else

                                    <p class="no-description">
                                        No description provided.
                                    </p>

                                @endif

                            </div>


                            {{-- PRICE --}}

                            <div class="fh-admin-menu-price">

                                <span>
                                    PRICE
                                </span>

                                <strong>
                                    ₱{{ number_format(
                                        $product->price,
                                        2
                                    ) }}
                                </strong>

                            </div>


                            {{-- STATUS --}}

                            <div class="fh-admin-menu-status">

                                @if($product->is_available)

                                    <span
                                        class="fh-menu-status available"
                                    >

                                        <span>
                                            ●
                                        </span>

                                        Available

                                    </span>

                                @else

                                    <span
                                        class="fh-menu-status unavailable"
                                    >

                                        <span>
                                            ●
                                        </span>

                                        Unavailable

                                    </span>

                                @endif

                            </div>


                            {{-- ACTIONS --}}

                            <div class="fh-admin-menu-action">


                                {{-- EDIT BUTTON --}}

                                <a
                                    href="{{ route(
                                        'admin.menu.edit',
                                        $product
                                    ) }}"
                                    class="fh-admin-menu-edit"
                                >
                                    ✏️ Edit
                                </a>

{{-- DELETE BUTTON --}}

@if(!$product->is_available)

    <form
        method="POST"
        action="{{ route(
            'admin.menu.destroy',
            $product
        ) }}"
        class="fh-delete-menu-form"
        data-product-name="{{ $product->name }}"
    >

        @csrf

        @method('DELETE')

        <button
            type="button"
            class="fh-admin-menu-delete"
            data-delete-menu
        >
            🗑 Delete
        </button>

    </form>

@else

    <button
        type="button"
        class="fh-admin-menu-delete disabled"
        disabled
        title="Set this item to unavailable before deleting it."
    >
        🔒 Delete
    </button>

@endif

                            </div>


                        </div>

                    @endforeach


                </div>

            @endif


        </div>

    </div>

</section>


{{-- =============================================================
     DELETE CONFIRMATION MODAL
============================================================== --}}

<div
    id="fhDeleteMenuModal"
    class="fh-delete-menu-modal"
    aria-hidden="true"
>


    {{-- DARK BACKDROP --}}

    <div
        class="fh-delete-menu-overlay"
        data-delete-cancel
    >
    </div>


    {{-- MODAL BOX --}}

    <div
        class="fh-delete-menu-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="fhDeleteMenuTitle"
    >


        {{-- ICON --}}

        <div class="fh-delete-menu-icon">
            ⚠️
        </div>


        {{-- TITLE --}}

        <h2 id="fhDeleteMenuTitle">
            Delete Menu Item?
        </h2>


        {{-- MESSAGE --}}

        <p>

            Are you sure you want to delete

            <strong id="fhDeleteMenuProductName">
                this menu item
            </strong>?

        </p>


        <span class="fh-delete-menu-warning">
            This action cannot be undone.
        </span>


        {{-- BUTTONS --}}

        <div class="fh-delete-menu-actions">

            <button
                type="button"
                class="fh-delete-menu-cancel"
                data-delete-cancel
            >
                Cancel
            </button>


            <button
                type="button"
                class="fh-delete-menu-confirm"
                id="fhDeleteMenuConfirm"
            >
                🗑 Delete Item
            </button>

        </div>


    </div>

</div>


<style>

/* =========================================================
   MAIN
========================================================= */

.fh-admin-menu-section {
    min-height: calc(100vh - 150px);
    padding: 45px 20px 80px;

    background: #0b0d0c;
    color: #ffffff;
}

.fh-admin-menu-container {
    width: min(1120px, 94%);
    margin: 0 auto;
}


/* =========================================================
   BACK
========================================================= */

.fh-admin-menu-back {
    display: inline-flex;
    align-items: center;

    margin-bottom: 25px;

    color: #ffffff;

    font-size: 13px;
    font-weight: 700;

    text-decoration: none;
}

.fh-admin-menu-back:hover {
    color: #22c55e;
}


/* =========================================================
   MESSAGES
========================================================= */

.fh-admin-menu-message {
    display: flex;
    align-items: center;

    gap: 10px;

    margin-bottom: 20px;
    padding: 13px 15px;

    border-radius: 11px;

    font-size: 13px;
    font-weight: 700;
}

.fh-admin-menu-message.success {
    background: #0d2115;
    border: 1px solid #285c38;
    color: #7ff0a2;
}

.fh-admin-menu-message.error {
    background: #241313;
    border: 1px solid #653131;
    color: #ffb5b5;
}

.fh-admin-menu-message > span {
    width: 22px;
    height: 22px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.08);
}


/* =========================================================
   HEADER
========================================================= */

.fh-admin-menu-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 25px;

    margin-bottom: 28px;
}

.fh-admin-menu-label {
    display: block;

    margin-bottom: 6px;

    color: #22c55e;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 1.7px;
}

.fh-admin-menu-header h1 {
    margin: 0;

    color: #ffffff;

    font-size: 36px;
    font-weight: 800;

    line-height: 1.15;
}

.fh-admin-menu-header p {
    max-width: 650px;

    margin: 9px 0 0;

    color: #9aa59e;

    font-size: 13px;
    line-height: 1.6;
}


/* =========================================================
   ADD BUTTON
========================================================= */

.fh-admin-menu-add-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    min-height: 43px;

    padding: 0 17px;

    background: #22c55e;

    border: 1px solid #22c55e;
    border-radius: 10px;

    color: #061009;

    font-size: 12px;
    font-weight: 800;

    text-decoration: none;
    white-space: nowrap;

    cursor: pointer;
}

.fh-admin-menu-add-button:hover {
    background: #22c55e;
    border-color: #22c55e;
    color: #061009;
}

.fh-admin-menu-add-button span {
    font-size: 16px;
    line-height: 1;
}


/* =========================================================
   SUMMARY
========================================================= */

.fh-admin-menu-summary {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 13px;

    margin-bottom: 25px;
}

.fh-admin-menu-summary-card {
    display: flex;
    align-items: center;

    gap: 13px;

    padding: 17px;

    background: #111512;

    border: 1px solid #243229;
    border-radius: 14px;
}

.fh-admin-menu-summary-icon {
    width: 44px;
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    background: #0d1b12;

    border: 1px solid #285238;
    border-radius: 11px;

    font-size: 19px;
}

.fh-admin-menu-summary-card span {
    display: block;

    margin-bottom: 3px;

    color: #8f9a92;

    font-size: 9px;
    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: 0.8px;
}

.fh-admin-menu-summary-card strong {
    display: block;

    color: #ffffff;

    font-size: 21px;
    font-weight: 800;
}


/* =========================================================
   PANEL
========================================================= */

.fh-admin-menu-panel {
    overflow: hidden;

    background: #111512;

    border: 1px solid #243229;
    border-radius: 17px;

    box-shadow: none;
}

.fh-admin-menu-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 21px 23px;

    border-bottom: 1px solid #243229;
}

.fh-admin-menu-panel-header h2 {
    margin: 4px 0 0;

    color: #ffffff;

    font-size: 19px;
    font-weight: 800;
}

.fh-admin-menu-count {
    padding: 7px 11px;

    background: #0d1b12;

    border: 1px solid #285238;
    border-radius: 8px;

    color: #22c55e;

    font-size: 10px;
    font-weight: 800;
}


/* =========================================================
   MENU LIST
========================================================= */

.fh-admin-menu-list {
    width: 100%;
}

.fh-admin-menu-item {
    display: grid;

    grid-template-columns:
        72px
        minmax(0, 1fr)
        105px
        115px
        190px;

    align-items: center;

    gap: 18px;

    padding: 17px 23px;

    border-bottom: 1px solid #202a24;
}

.fh-admin-menu-item:last-child {
    border-bottom: none;
}


/* =========================================================
   IMAGE
========================================================= */

.fh-admin-menu-image {
    width: 72px;
    height: 72px;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    background: #0d110f;

    border: 1px solid #29362e;
    border-radius: 12px;

    color: #22c55e;

    font-size: 27px;
}

.fh-admin-menu-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}


/* =========================================================
   INFO
========================================================= */

.fh-admin-menu-info {
    min-width: 0;
}

.fh-admin-menu-category {
    display: block;

    margin-bottom: 4px;

    color: #22c55e;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 1px;

    text-transform: uppercase;
}

.fh-admin-menu-info h3 {
    margin: 0;

    color: #ffffff;

    font-size: 14px;
    font-weight: 800;
}

.fh-admin-menu-info p {
    margin: 4px 0 0;

    overflow: hidden;

    color: #9aa59e;

    font-size: 10px;
    line-height: 1.5;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.fh-admin-menu-info p.no-description {
    color: #68736c;
}


/* =========================================================
   PRICE
========================================================= */

.fh-admin-menu-price span {
    display: block;

    margin-bottom: 4px;

    color: #7f8b83;

    font-size: 9px;
    font-weight: 800;
}

.fh-admin-menu-price strong {
    color: #22c55e;

    font-size: 14px;
    font-weight: 800;
}


/* =========================================================
   STATUS
========================================================= */

.fh-menu-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 5px;

    padding: 7px 9px;

    border-radius: 999px;

    font-size: 9px;
    font-weight: 800;

    white-space: nowrap;
}

.fh-menu-status.available {
    background: rgba(34, 197, 94, 0.10);

    border: 1px solid rgba(34, 197, 94, 0.23);

    color: #22c55e;
}

.fh-menu-status.unavailable {
    background: #171a18;

    border: 1px solid #303832;

    color: #9ba39d;
}

.fh-menu-status span {
    font-size: 8px;
}


/* =========================================================
   ACTIONS
========================================================= */

.fh-admin-menu-action {
    display: flex;
    align-items: center;

    gap: 8px;
}

.fh-admin-menu-action form {
    margin: 0;

    flex: 1;
}


/* EDIT */

.fh-admin-menu-edit {
    flex: 1;

    min-height: 36px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0 10px;

    background: #0d2115;

    border: 1px solid #285c38;
    border-radius: 9px;

    color: #4ade80;

    font-family: inherit;

    font-size: 10px;
    font-weight: 800;

    text-decoration: none;

    cursor: pointer;
}

.fh-admin-menu-edit:hover {
    background: #12331d;

    border-color: #3d7d4e;

    color: #86efac;
}


/* DELETE */

.fh-admin-menu-delete {
    width: 100%;

    min-height: 36px;

    padding: 0 10px;

    background: #241313;

    border: 1px solid #653131;
    border-radius: 9px;

    color: #ff7777;

    font-family: inherit;

    font-size: 10px;
    font-weight: 800;

    cursor: pointer;
}

.fh-admin-menu-delete:hover {
    background: #2c1717;

    border-color: #7d3b3b;

    color: #ff7777;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.fh-admin-menu-empty {
    padding: 70px 20px;

    text-align: center;
}

.fh-admin-menu-empty-icon {
    margin-bottom: 12px;

    font-size: 45px;
}

.fh-admin-menu-empty h3 {
    margin: 0 0 7px;

    color: #ffffff;

    font-size: 20px;
    font-weight: 800;
}

.fh-admin-menu-empty p {
    max-width: 430px;

    margin: 0 auto 20px;

    color: #8f9a92;

    font-size: 12px;
    line-height: 1.6;
}


/* =========================================================
   DELETE MODAL
========================================================= */

.fh-delete-menu-modal {
    position: fixed;

    inset: 0;

    z-index: 10000;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    box-sizing: border-box;
}

.fh-delete-menu-modal.open {
    display: flex;
}


/* BACKDROP */

.fh-delete-menu-overlay {
    position: absolute;

    inset: 0;

    background: rgba(0, 0, 0, 0.78);
}


/* BOX */

.fh-delete-menu-box {
    position: relative;

    z-index: 1;

    width: min(430px, 100%);

    padding: 30px;

    background: #111512;

    border: 1px solid #4b2929;

    border-radius: 18px;

    text-align: center;

    box-shadow:
        0 20px 55px rgba(0, 0, 0, 0.55);
}


/* ICON */

.fh-delete-menu-icon {
    width: 60px;
    height: 60px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0 auto 17px;

    background: #241313;

    border: 1px solid #653131;
    border-radius: 14px;

    font-size: 26px;
}


/* TITLE */

.fh-delete-menu-box h2 {
    margin: 0 0 9px;

    color: #ffffff;

    font-size: 22px;
    font-weight: 800;
}


/* MESSAGE */

.fh-delete-menu-box p {
    margin: 0;

    color: #a9b2ac;

    font-size: 13px;
    line-height: 1.6;
}

.fh-delete-menu-box p strong {
    color: #ffffff;

    font-weight: 800;
}


/* WARNING */

.fh-delete-menu-warning {
    display: block;

    margin-top: 8px;

    color: #ff7777;

    font-size: 11px;
    font-weight: 700;
}


/* BUTTONS */

.fh-delete-menu-actions {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 9px;

    margin-top: 24px;
}

.fh-delete-menu-cancel,
.fh-delete-menu-confirm {
    min-height: 43px;

    padding: 0 14px;

    border-radius: 10px;

    font-family: inherit;

    font-size: 12px;
    font-weight: 800;

    cursor: pointer;
}


/* CANCEL */

.fh-delete-menu-cancel {
    background: #0d110f;

    border: 1px solid #344038;

    color: #ffffff;
}

.fh-delete-menu-cancel:hover {
    background: #0d110f;

    border-color: #4b5b51;

    color: #ffffff;
}


/* CONFIRM */

.fh-delete-menu-confirm {
    background: #d63c3c;

    border: 1px solid #d63c3c;

    color: #ffffff;
}

.fh-delete-menu-confirm:hover {
    background: #d63c3c;

    border-color: #d63c3c;

    color: #ffffff;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 1050px) {

    .fh-admin-menu-item {
        grid-template-columns:
            65px
            minmax(0, 1fr)
            100px
            105px
            175px;
    }

    .fh-admin-menu-image {
        width: 65px;
        height: 65px;
    }

}


@media (max-width: 850px) {

    .fh-admin-menu-item {
        grid-template-columns:
            65px
            minmax(0, 1fr)
            100px
            175px;
    }

    .fh-admin-menu-status {
        grid-column: 3;
    }

    .fh-admin-menu-action {
        grid-column: 4;
    }

}


@media (max-width: 750px) {

    .fh-admin-menu-section {
        padding: 35px 16px 60px;
    }

    .fh-admin-menu-container {
        width: 100%;
    }

    .fh-admin-menu-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .fh-admin-menu-header h1 {
        font-size: 30px;
    }

    .fh-admin-menu-header .fh-admin-menu-add-button {
        width: 100%;

        box-sizing: border-box;
    }

    .fh-admin-menu-summary {
        grid-template-columns: 1fr;
    }

    .fh-admin-menu-panel-header {
        align-items: flex-start;

        gap: 10px;

        flex-direction: column;
    }

    .fh-admin-menu-item {
        grid-template-columns:
            58px
            minmax(0, 1fr);

        gap: 12px;

        padding: 15px 18px;
    }

    .fh-admin-menu-image {
        width: 58px;
        height: 58px;
    }

    .fh-admin-menu-price,
    .fh-admin-menu-status,
    .fh-admin-menu-action {
        grid-column: 2;
    }

    .fh-admin-menu-price {
        margin-top: 3px;
    }

    .fh-admin-menu-action {
        margin-top: 2px;

        width: 100%;
    }

    .fh-admin-menu-edit,
    .fh-admin-menu-delete {
        min-height: 40px;
    }

    .fh-delete-menu-box {
        padding: 25px 20px;
    }

    .fh-delete-menu-actions {
        grid-template-columns: 1fr;
    }

    .fh-delete-menu-confirm {
        order: 1;
    }

    .fh-delete-menu-cancel {
        order: 2;
    }

}
.fh-admin-menu-delete.disabled {
    background: #171a18;
    border-color: #303832;
    color: #68736c;
    cursor: not-allowed;
    opacity: 0.8;
}

</style>


{{-- =============================================================
     DELETE MODAL JAVASCRIPT
============================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById(
        'fhDeleteMenuModal'
    );

    const productName = document.getElementById(
        'fhDeleteMenuProductName'
    );

    const confirmButton = document.getElementById(
        'fhDeleteMenuConfirm'
    );

    const cancelButtons = document.querySelectorAll(
        '[data-delete-cancel]'
    );

    const deleteButtons = document.querySelectorAll(
        '[data-delete-menu]'
    );

    let currentForm = null;


    /*
    |--------------------------------------------------------------------------
    | OPEN MODAL
    |--------------------------------------------------------------------------
    */

    deleteButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            currentForm = button.closest(
                '.fh-delete-menu-form'
            );

            if (!currentForm) {
                return;
            }


            const name =
                currentForm.dataset.productName ||
                'this menu item';


            productName.textContent = name;


            modal.classList.add('open');

            modal.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body.style.overflow = 'hidden';

        });

    });


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    function closeDeleteModal() {

        modal.classList.remove('open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';

        currentForm = null;

    }


    cancelButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            closeDeleteModal
        );

    });


    /*
    |--------------------------------------------------------------------------
    | CONFIRM DELETE
    |--------------------------------------------------------------------------
    */

    confirmButton.addEventListener(
        'click',
        function () {

            if (currentForm) {

                currentForm.submit();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal.classList.contains('open')
            ) {

                closeDeleteModal();

            }

        }
    );

});

</script>

@endsection