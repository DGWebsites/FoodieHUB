@extends('layouts.app')

@section('content')

<section class="admin-create-menu-section">

    <div class="container">


        {{-- BACK BUTTON --}}

        <a
            href="{{ route('admin.dashboard') }}"
            class="back-orders"
        >
            ← Back to Dashboard
        </a>


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="menu-success-message">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR MESSAGE --}}

        @if($errors->any())

            <div class="menu-error-message">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- PAGE HEADER --}}

        <div class="admin-create-menu-header">

            <span class="section-label">
                ADMIN PANEL
            </span>

            <h1>
                Add Menu Item
            </h1>

            <p>
                Add a new food item that customers can order from
                the FoodieHub menu.
            </p>

        </div>


        {{-- FORM CARD --}}

        <div class="admin-create-menu-card">

            <form
                method="POST"
                action="{{ route('admin.menu.store') }}"
                enctype="multipart/form-data"
                class="admin-create-menu-form"
            >

                @csrf


                {{-- FOOD NAME --}}

                <div class="admin-menu-form-group">

                    <label for="name">
                        Food Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter food name"
                        required
                    >

                </div>


                {{-- CATEGORY + PRICE --}}

                <div class="admin-menu-form-row">

                    <div class="admin-menu-form-group">

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
                                    {{ old('category_id') == $category->id
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="admin-menu-form-group">

                        <label for="price">
                            Price
                        </label>

                        <div class="admin-menu-price-input">

                            <span>
                                ₱
                            </span>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                placeholder="0.00"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>

                </div>


                {{-- DESCRIPTION --}}

                <div class="admin-menu-form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Describe the food item..."
                    >{{ old('description') }}</textarea>

                </div>


                {{-- IMAGE --}}

                <div class="admin-menu-form-group">

                    <label for="image">
                        Food Image
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="admin-menu-input-help">
                        JPG, JPEG, PNG, or WEBP. Maximum size: 2MB.
                    </small>

                </div>


                {{-- AVAILABILITY --}}

                <div class="admin-menu-availability">

                    <div class="admin-menu-availability-icon">
                        🍽️
                    </div>

                    <div class="admin-menu-availability-text">

                        <strong>
                            Available for Ordering
                        </strong>

                        <p>
                            Customers can order this item immediately
                            when it is marked as available.
                        </p>

                    </div>

                    <label class="admin-menu-toggle">

                        <input
                            type="checkbox"
                            name="is_available"
                            value="1"
                            {{ old('is_available', true)
                                ? 'checked'
                                : '' }}
                        >

                        <span>
                            Available
                        </span>

                    </label>

                </div>


                {{-- ACTION BUTTONS --}}

                <div class="admin-menu-form-actions">

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="admin-menu-cancel-button"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="admin-menu-create-button"
                    >
                        + Add Menu Item
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection