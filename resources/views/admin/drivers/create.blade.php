@extends('layouts.app')

@section('content')

<section class="admin-create-driver-section">

    <div class="container">


        <a
            href="{{ route('admin.drivers.index') }}"
            class="back-orders"
        >
            ← Back to Drivers
        </a>


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="admin-create-driver-header">

            <span class="section-label">
                ADMIN PANEL
            </span>

            <h1>
                Add Delivery Driver
            </h1>

            <p>
                Create a private driver account that can be assigned
                to FoodieHub orders.
            </p>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <div class="admin-create-driver-card">


            @if($errors->any())

                <div class="driver-error-message">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.drivers.store') }}"
                class="admin-create-driver-form"
            >

                @csrf


                {{-- NAME --}}

                <div class="admin-driver-form-group">

                    <label for="name">
                        Driver Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter driver's full name"
                        required
                    >

                </div>


                {{-- EMAIL --}}

                <div class="admin-driver-form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter driver's email"
                        required
                    >

                </div>


                {{-- PASSWORD --}}

                <div class="admin-driver-form-row">

                    <div class="admin-driver-form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimum 8 characters"
                            required
                        >

                    </div>


                    {{-- CONFIRM PASSWORD --}}

                    <div class="admin-driver-form-group">

                        <label for="password_confirmation">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repeat password"
                            required
                        >

                    </div>

                </div>


                {{-- SECURITY NOTICE --}}

                <div class="admin-driver-security-notice">

                    <div class="admin-driver-security-icon">
                        🔒
                    </div>

                    <div>

                        <strong>
                            Private Driver Account
                        </strong>

                        <p>
                            This account is created by the administrator.
                            Drivers cannot register themselves through the
                            customer registration page.
                        </p>

                    </div>

                </div>


                {{-- ACTION BUTTONS --}}

                <div class="admin-driver-form-actions">

                    <a
                        href="{{ route('admin.drivers.index') }}"
                        class="admin-driver-cancel-button"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="admin-driver-create-button"
                    >
                        🚚 Create Driver Account
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection