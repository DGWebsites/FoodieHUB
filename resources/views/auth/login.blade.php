@extends('layouts.app')

@section('content')

<section class="auth-section">

    <div class="auth-container">

        <div class="auth-card">

            <div class="auth-header">

                <div class="auth-icon">
                    🔐
                </div>

                <span class="section-label">
                    WELCOME BACK
                </span>

                <h1>
                    Login
                </h1>

                <p>
                    Sign in to continue ordering your favorite food.
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
                action="{{ route('login') }}"
                class="auth-form"
            >

                @csrf


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
                        placeholder="Enter your password"
                        required
                    >

                </div>


                <label class="remember-option">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >

                    <span>
                        Remember me
                    </span>

                </label>


                <button
                    type="submit"
                    class="auth-submit"
                >
                    Login
                </button>

            </form>


            <div class="auth-footer">

                <p>
                    Don't have an account?
                </p>

                <a href="{{ route('register') }}">
                    Create an account
                </a>

            </div>

        </div>

    </div>

</section>

@endsection