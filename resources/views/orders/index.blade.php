@extends('layouts.app')

@section('content')

<section class="orders-section">

    <div class="container">

        <div class="orders-heading">

            <span class="section-label">
                MY ORDERS
            </span>

            <h1>
                Order History
            </h1>

            <p>
                View your previous and current food orders.
            </p>

        </div>


        @if(session('success'))

            <div class="order-success">
                {{ session('success') }}
            </div>

        @endif


        @if($orders->isEmpty())

            <div class="orders-empty">

                <div class="orders-empty-icon">
                    🛒
                </div>

                <h2>
                    No orders yet
                </h2>

                <p>
                    You haven't placed an order yet.
                </p>

                <a
                    href="{{ route('home') }}"
                    class="primary-button"
                >
                    Browse Food
                </a>

            </div>

        @else

            <div class="orders-list">

                @foreach($orders as $order)

                    <article class="order-card">

                        <div class="order-card-top">

                            <div>

                                <span class="order-label">
                                    ORDER #{{ $order->id }}
                                </span>

                                <h2>
                                    Order placed
                                </h2>

                                <p>
                                    {{ $order->created_at->format(
                                        'F d, Y h:i A'
                                    ) }}
                                </p>

                            </div>


                            <span
                                class="order-status
                                status-{{ strtolower(
                                    str_replace(
                                        ' ',
                                        '-',
                                        $order->status
                                    )
                                ) }}"
                            >
                                {{ $order->status }}
                            </span>

                        </div>


                        <div class="order-card-middle">

                            <div>

                                <span>
                                    Total
                                </span>

                                <strong>
                                    ₱{{ number_format(
                                        $order->total,
                                        2
                                    ) }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Payment
                                </span>

                                <strong>
                                    {{ $order->payment_method }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Items
                                </span>

                                <strong>
                                    {{ $order->orderItems->sum('quantity') }}
                                </strong>

                            </div>

                        </div>


                        <div class="order-card-bottom">

                            <a
                                href="{{ route(
                                    'orders.show',
                                    $order
                                ) }}"
                                class="view-order-button"
                            >
                                View Order →
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection