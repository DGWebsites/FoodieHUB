@extends('layouts.app')

@section('content')

<section class="auth-section admin-login-section">

    <div class="auth-container">

        <div class="auth-card">

            <div class="auth-header">

                <div class="auth-icon">
                    🛡️
                </div>

                <span class="section-label">
                    FOODIEHUB ADMIN
                </span>

                <h1>
                    Admin Login
                </h1>

                <p>
                    Sign in to manage products, orders, users, and categories.
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
                action="{{ route('admin.login.store') }}"
                class="auth-form"
            >

                @csrf


                <div class="form-group">

                    <label for="email">
                        Admin Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter admin email"
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
                        placeholder="Enter admin password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="auth-submit"
                >
                    Login to Admin Panel
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