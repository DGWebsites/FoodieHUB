@extends('layouts.app')

@section('content')

<section class="simple-tutorial-section">

    <div class="container">

        <div class="simple-tutorial-card">

            <span class="simple-tutorial-label">
                FOODIEHUB TUTORIAL
            </span>

            <h1>
                How to Order
            </h1>

            <p class="simple-tutorial-intro">
                Follow these simple steps to order your favorite food
                through FoodieHub.
            </p>


            <div class="tutorial-step">

                <div class="tutorial-step-number">
                    1
                </div>

                <div class="tutorial-step-content">

                    <h2>
                        Browse the Menu
                    </h2>

                    <p>
                        Go to the FoodieHub home page and browse the
                        available food. You can also search for a specific
                        food or choose a category.
                    </p>

                </div>

            </div>


            <div class="tutorial-step">

                <div class="tutorial-step-number">
                    2
                </div>

                <div class="tutorial-step-content">

                    <h2>
                        Choose Your Food
                    </h2>

                    <p>
                        Select a food item to view its details, price,
                        and description. Choose what you want to order.
                    </p>

                </div>

            </div>


            <div class="tutorial-step">

                <div class="tutorial-step-number">
                    3
                </div>

                <div class="tutorial-step-content">

                    <h2>
                        Add to Cart
                    </h2>

                    <p>
                        Click the Cart button to add the food to your
                        shopping cart. You can update the quantity or
                        remove items before checkout.
                    </p>

                </div>

            </div>


            <div class="tutorial-step">

                <div class="tutorial-step-number">
                    4
                </div>

                <div class="tutorial-step-content">

                    <h2>
                        Checkout
                    </h2>

                    <p>
                        Review your cart, enter your delivery information,
                        and choose your payment method before placing
                        your order.
                    </p>

                </div>

            </div>


            <div class="tutorial-step">

                <div class="tutorial-step-number">
                    5
                </div>

                <div class="tutorial-step-content">

                    <h2>
                        Track Your Order
                    </h2>

                    <p>
                        After placing your order, go to My Orders to view
                        your order status and track its progress until
                        delivery.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('home') }}"
                class="simple-tutorial-button"
            >
                Start Ordering →
            </a>

        </div>

    </div>

</section>

@endsection