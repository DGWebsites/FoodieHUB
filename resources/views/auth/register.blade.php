@extends('layouts.app')

@section('content')

<section class="auth-section">

    <div class="auth-container">

        <div class="auth-card">

            <div class="auth-header">

                <div class="auth-icon">
                    🍔
                </div>

                <span class="section-label">
                    JOIN FOODIEHUB
                </span>

                <h1>
                    Create Account
                </h1>

                <p>
                    Create your account and start ordering delicious food.
                </p>

            </div>


            @if($errors->any())

                <div class="auth-error">

                    <strong>
                        Please check the following:
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
                action="{{ route('register') }}"
                class="auth-form"
            >

                @csrf


                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        required
                        autofocus
                    >

                </div>


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
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
                        placeholder="Minimum 8 characters"
                        minlength="8"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password_confirmation">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Re-enter your password"
                        minlength="8"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="auth-submit"
                >
                    Create Account
                </button>

            </form>


            <div class="auth-footer">

                <p>
                    Already have an account?
                </p>

                <a href="{{ route('login') }}">
                    Login here
                </a>

            </div>

        </div>

    </div>

</section>

@endsection