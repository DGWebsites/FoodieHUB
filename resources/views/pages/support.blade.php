@extends('layouts.app')

@section('content')

<section class="simple-support-section">

    <div class="container">

        <div class="simple-support-card">

            <span class="simple-support-label">
                FOODIEHUB SUPPORT
            </span>

            <h1>
                Support
            </h1>

            <p class="simple-support-intro">
                Ask our assistant first — it can help with available food,
                prices, delivery information, and your order status.
                If it cannot solve your concern, you can contact our team directly.
            </p>

            <p class="simple-support-response">
                Our team typically replies within about 72 hours.
            </p>


            {{-- =====================================================
                 ASK THE ASSISTANT
            ====================================================== --}}

            <div class="support-block">

                <span class="support-block-label">
                    01
                </span>

                <h2>
                    Ask the assistant
                </h2>

                <p>
                    Get quick answers about available food, prices,
                    delivery information, and your current order status.
                </p>

                <a
                    href="#"
                    class="support-primary-button"
                    onclick="document.getElementById('fhAssistantOpen').click(); return false;"
                >
                    Start Chatting →
                </a>

            </div>


            {{-- =====================================================
                 SPECIFIC ORDER
            ====================================================== --}}

            <div class="support-block">

                <span class="support-block-label">
                    02
                </span>

                <h2>
                    Help with a specific order
                </h2>

                <p>
                    Starting from your order helps us see what you bought
                    and check where your delivery is without requiring you
                    to explain everything again.
                </p>

                <a
                    href="{{ route('orders.index') }}"
                    class="support-secondary-button"
                >
                    Find My Order →
                </a>

            </div>


            {{-- =====================================================
                 CONVERSATIONS
            ====================================================== --}}

            <div class="support-block">

                <span class="support-block-label">
                    03
                </span>

                <h2>
                    Your conversations
                </h2>

                <div class="support-empty">

                    <div class="support-empty-icon">
                        💬
                    </div>

                    <h3>
                        No conversations yet
                    </h3>

                    <p>
                        When you message the FoodieHub team, your conversation
                        can be shown here so you can easily return to it.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                 QUICK ANSWERS
            ====================================================== --}}

            <div class="support-block">

                <span class="support-block-label">
                    04
                </span>

                <h2>
                    Answers you can read right now
                </h2>

                <div class="support-help-grid">

                    <a
                        href="#"
                        class="support-help-card"
                    >

                        <strong>
                            FAQ
                        </strong>

                        <span>
                            Common questions about ordering, payments,
                            delivery, and refunds.
                        </span>

                    </a>


                    <a
                        href="{{ route('tutorial') }}"
                        class="support-help-card"
                    >

                        <strong>
                            How It Works
                        </strong>

                        <span>
                            See how to browse, order, checkout,
                            and track your food.
                        </span>

                    </a>


                    <a
                        href="#"
                        class="support-help-card"
                    >

                        <strong>
                            Refund Policy
                        </strong>

                        <span>
                            Learn when refunds may be available
                            for cancelled or unsuccessful orders.
                        </span>

                    </a>


                    <a
                        href="{{ route('status') }}"
                        class="support-help-card"
                    >

                        <strong>
                            Delivery Status
                        </strong>

                        <span>
                            Check FoodieHub's current service status
                            and order activity.
                        </span>

                    </a>

                </div>

            </div>


            {{-- =====================================================
                 ACCOUNT
            ====================================================== --}}

            <div class="support-account">

                <p>
                    Have an account?
                </p>

                @guest

                    <a href="{{ route('login') }}">
                        Sign in
                    </a>

                    <span>
                        to access your account and orders.
                    </span>

                @else

                    <a href="{{ route('orders.index') }}">
                        View My Orders
                    </a>

                    <span>
                        to access your order history.
                    </span>

                @endguest

            </div>

        </div>

    </div>

</section>

@endsection