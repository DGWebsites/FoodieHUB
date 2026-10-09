@extends('layouts.app')

@section('content')

<section class="auth-section driver-login-section">

    <div class="auth-container">

        <div class="auth-card">

            <div class="auth-header">

                <div class="auth-icon">
                    🚚
                </div>

                <span class="section-label">
                    FOODIEHUB DELIVERY
                </span>

                <h1>
                    Driver Login
                </h1>

                <p>
                    Sign in to view your assigned deliveries and manage your orders.
                </p>

            </div>


            @if($errors->any())

                <div class="auth-error">

                    <strong>
                        Login failed
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


            <form
                method="POST"
                action="{{ route('driver.login.store') }}"
                class="auth-form"
            >

                @csrf


                <div class="form-group">

                    <label for="email">
                        Driver Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter driver email"
                        required
                        autofocus
                    >

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter driver password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="auth-submit"
                >
                    Login to Driver Dashboard
                </button>

            </form>


            <div class="auth-footer">

                <a href="{{ route('home') }}">
                    ← Back to FoodieHub
                </a>

            </div>

        </div>

    </div>

</section>

@endsection