@extends('layouts.app')

@section('content')

<section class="fh-admin-menu-edit-section">

    <div class="fh-admin-menu-edit-container">

        {{-- BACK --}}

        <a
            href="{{ route('admin.menu.index') }}"
            class="fh-admin-menu-edit-back"
        >
            ← Back to Menu Management
        </a>


        {{-- HEADER --}}

        <div class="fh-admin-menu-edit-header">

            <span class="section-label">
                MENU MANAGEMENT
            </span>

            <h1>
                Edit Menu Item
            </h1>

            <p>
                Update the information for this FoodieHub menu item.
            </p>

        </div>


        {{-- VALIDATION ERRORS --}}

        @if($errors->any())

            <div class="fh-admin-menu-edit-errors">

                <strong>
                    Please fix the following:
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


        {{-- FORM --}}

        <div class="fh-admin-menu-edit-card">

            <form
                method="POST"
                action="{{ route('admin.menu.update', $product) }}"
                enctype="multipart/form-data"
                class="fh-admin-menu-edit-form"
            >

                @csrf
                @method('PUT')


                {{-- FOOD NAME --}}

                <div class="fh-admin-menu-edit-field">

                    <label for="name">
                        Food Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        placeholder="Enter food name"
                        required
                    >

                </div>


                {{-- CATEGORY --}}

                <div class="fh-admin-menu-edit-field">

                    <label for="category_id">
                        Category
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        required
                    >

                        <option value="">
                            Select a category
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old(
                                    'category_id',
                                    $product->category_id
                                ) == $category->id
                                    ? 'selected'
                                    : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- PRICE --}}

                <div class="fh-admin-menu-edit-field">

                    <label for="price">
                        Price
                    </label>

                    <div class="fh-admin-menu-edit-price-wrap">

                        <span>
                            ₱
                        </span>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price', $product->price) }}"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                            required
                        >

                    </div>

                </div>


                {{-- DESCRIPTION --}}

                <div class="fh-admin-menu-edit-field">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Describe the food item..."
                    >{{ old('description', $product->description) }}</textarea>

                </div>


                {{-- CURRENT IMAGE --}}

                @if($product->image)

                    <div class="fh-admin-menu-edit-field">

                        <label>
                            Current Image
                        </label>

                        <div class="fh-admin-menu-edit-current-image">

                            <img
                                src="{{ asset(
                                    'storage/' . $product->image
                                ) }}"
                                alt="{{ $product->name }}"
                            >

                        </div>

                    </div>

                @endif


                {{-- NEW IMAGE --}}

                <div class="fh-admin-menu-edit-field">

                    <label for="image">
                        Replace Image
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <span class="fh-admin-menu-edit-help">
                        Leave empty to keep the current image.
                    </span>

                </div>


                {{-- AVAILABILITY --}}

                <div class="fh-admin-menu-edit-availability">

                    <label class="fh-admin-menu-edit-checkbox">

                        <input
                            type="checkbox"
                            name="is_available"
                            value="1"
                            {{ old(
                                'is_available',
                                $product->is_available
                            )
                                ? 'checked'
                                : '' }}
                        >

                        <span>
                            Available for customers
                        </span>

                    </label>

                    <p>
                        Uncheck this when the item is temporarily
                        unavailable. It will remain in the database
                        and can be edited again later.
                    </p>

                </div>


                {{-- ACTIONS --}}

                <div class="fh-admin-menu-edit-actions">

                    <a
                        href="{{ route('admin.menu.index') }}"
                        class="fh-admin-menu-edit-cancel"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="fh-admin-menu-edit-save"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>


<style>

/* =========================================================
   PAGE
========================================================= */

.fh-admin-menu-edit-section {
    min-height: calc(100vh - 180px);

    padding: 55px 20px 80px;

    background: #0b0d0c;

    color: #ffffff;

    box-sizing: border-box;
}


.fh-admin-menu-edit-container {
    width: 100%;
    max-width: 820px;

    margin: 0 auto;
}


/* =========================================================
   BACK
========================================================= */

.fh-admin-menu-edit-back {
    display: inline-flex;

    margin-bottom: 25px;

    color: #8f9a92;

    text-decoration: none;

    font-size: 13px;
    font-weight: 700;

    transition: 0.2s ease;
}


.fh-admin-menu-edit-back:hover {
    color: #22c55e;
}


/* =========================================================
   HEADER
========================================================= */

.fh-admin-menu-edit-header {
    margin-bottom: 28px;
}


.fh-admin-menu-edit-header h1 {
    margin: 7px 0 8px;

    color: #ffffff;

    font-size: 38px;
    font-weight: 800;

    letter-spacing: -0.8px;
}


.fh-admin-menu-edit-header p {
    margin: 0;

    color: #8f9a92;

    font-size: 14px;
}


/* =========================================================
   ERRORS
========================================================= */

.fh-admin-menu-edit-errors {
    margin-bottom: 20px;

    padding: 16px 18px;

    border: 1px solid rgba(239, 68, 68, 0.30);

    border-radius: 12px;

    background: rgba(239, 68, 68, 0.08);

    color: #fca5a5;

    font-size: 13px;
}


.fh-admin-menu-edit-errors strong {
    color: #f87171;
}


.fh-admin-menu-edit-errors ul {
    margin: 8px 0 0;
    padding-left: 18px;
}


/* =========================================================
   CARD
========================================================= */

.fh-admin-menu-edit-card {
    padding: 30px;

    background: #111413;

    border: 1px solid #1f2a24;

    border-radius: 20px;

    box-shadow:
        0 15px 40px rgba(0, 0, 0, 0.30);
}


/* =========================================================
   FORM
========================================================= */

.fh-admin-menu-edit-field {
    margin-bottom: 22px;
}


.fh-admin-menu-edit-field label {
    display: block;

    margin-bottom: 8px;

    color: #ffffff;

    font-size: 13px;
    font-weight: 800;
}


.fh-admin-menu-edit-field input[type="text"],
.fh-admin-menu-edit-field input[type="number"],
.fh-admin-menu-edit-field input[type="file"],
.fh-admin-menu-edit-field select,
.fh-admin-menu-edit-field textarea {

    width: 100%;

    box-sizing: border-box;

    border: 1px solid #2a362f;

    border-radius: 11px;

    background: #0d100e;

    color: #ffffff;

    font-family: inherit;

    font-size: 13px;

    outline: none;
}


.fh-admin-menu-edit-field input[type="text"],
.fh-admin-menu-edit-field input[type="number"],
.fh-admin-menu-edit-field input[type="file"],
.fh-admin-menu-edit-field select {

    min-height: 46px;

    padding: 0 14px;
}


.fh-admin-menu-edit-field textarea {

    padding: 13px 14px;

    resize: vertical;
}


.fh-admin-menu-edit-field input:focus,
.fh-admin-menu-edit-field select:focus,
.fh-admin-menu-edit-field textarea:focus {

    border-color: #22c55e;

    box-shadow:
        0 0 0 3px rgba(34, 197, 94, 0.08);
}


/* =========================================================
   PRICE
========================================================= */

.fh-admin-menu-edit-price-wrap {
    position: relative;
}


.fh-admin-menu-edit-price-wrap > span {

    position: absolute;

    left: 14px;
    top: 50%;

    transform: translateY(-50%);

    color: #22c55e;

    font-size: 14px;
    font-weight: 800;

    pointer-events: none;
}


.fh-admin-menu-edit-price-wrap input {
    padding-left: 32px !important;
}


/* =========================================================
   CURRENT IMAGE
========================================================= */

.fh-admin-menu-edit-current-image {

    width: 180px;
    height: 130px;

    overflow: hidden;

    border: 1px solid #2a362f;

    border-radius: 14px;

    background: #0d100e;
}


.fh-admin-menu-edit-current-image img {

    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}


/* =========================================================
   FILE HELP
========================================================= */

.fh-admin-menu-edit-help {

    display: block;

    margin-top: 7px;

    color: #7f8982;

    font-size: 11px;
}


/* =========================================================
   AVAILABILITY
========================================================= */

.fh-admin-menu-edit-availability {

    margin-top: 5px;
    margin-bottom: 25px;

    padding: 17px;

    border: 1px solid #263129;

    border-radius: 13px;

    background: #0d100e;
}


.fh-admin-menu-edit-checkbox {

    display: flex;

    align-items: center;

    gap: 10px;

    cursor: pointer;

    color: #ffffff;

    font-size: 13px;
    font-weight: 800;
}


.fh-admin-menu-edit-checkbox input {

    width: 18px;
    height: 18px;

    accent-color: #22c55e;

    cursor: pointer;
}


.fh-admin-menu-edit-availability p {

    margin: 8px 0 0 28px;

    color: #7f8982;

    font-size: 11px;

    line-height: 1.5;
}


/* =========================================================
   ACTIONS
========================================================= */

.fh-admin-menu-edit-actions {

    display: flex;

    gap: 10px;

    padding-top: 6px;
}


.fh-admin-menu-edit-cancel,
.fh-admin-menu-edit-save {

    flex: 1;

    min-height: 48px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    font-size: 13px;

    font-weight: 800;

    cursor: pointer;

    text-decoration: none;
}


.fh-admin-menu-edit-cancel {

    border: 1px solid #344038;

    background: #0d100e;

    color: #ffffff;
}


.fh-admin-menu-edit-cancel:hover {

    background: #151a17;

    border-color: #4a574f;
}


.fh-admin-menu-edit-save {

    border: 1px solid #22c55e;

    background: #22c55e;

    color: #061009;
}


.fh-admin-menu-edit-save:hover {

    background: #16a34a;

    border-color: #16a34a;

    color: #ffffff;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 650px) {

    .fh-admin-menu-edit-section {
        padding-left: 16px;
        padding-right: 16px;
    }


    .fh-admin-menu-edit-card {
        padding: 22px 18px;
    }


    .fh-admin-menu-edit-header h1 {
        font-size: 30px;
    }


    .fh-admin-menu-edit-actions {
        flex-direction: column;
    }


    .fh-admin-menu-edit-cancel,
    .fh-admin-menu-edit-save {
        width: 100%;
    }

}

</style>

@endsection