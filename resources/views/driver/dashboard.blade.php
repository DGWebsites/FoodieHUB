@extends('layouts.app')

@section('content')

<section class="driver-dashboard-section">

    <div class="container">

        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div class="success-message">
                {{ session('success') }}
            </div>

        @endif


        {{-- =====================================================
             ERROR MESSAGE
        ====================================================== --}}

        @if($errors->any())

            <div class="error-message">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             DASHBOARD HEADER
        ====================================================== --}}

        <div class="driver-dashboard-header">

            <div>

                <span class="section-label">
                    FOODIEHUB DELIVERY
                </span>

                <h1>
                    Driver Dashboard
                </h1>

                <p>
                    Welcome back, {{ auth()->user()->name }}.
                    Manage your assigned deliveries here.
                </p>

            </div>


            <div class="driver-user-badge">

                <div class="driver-user-icon">
                    🚚
                </div>

                <div>

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Delivery Driver
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
             DRIVER STATISTICS
        ====================================================== --}}

        <div class="driver-stats-grid">

            <div class="driver-stat-card">

                <div class="driver-stat-icon">
                    📦
                </div>

                <div>

                    <span>
                        Assigned Orders
                    </span>

                    <strong>
                        {{ $assignedCount }}
                    </strong>

                </div>

            </div>


            <div class="driver-stat-card">

                <div class="driver-stat-icon">
                    🚚
                </div>

                <div>

                    <span>
                        Out for Delivery
                    </span>

                    <strong>
                        {{ $outForDeliveryCount }}
                    </strong>

                </div>

            </div>


            <div class="driver-stat-card">

                <div class="driver-stat-icon">
                    ✅
                </div>

                <div>

                    <span>
                        Delivered
                    </span>

                    <strong>
                        {{ $deliveredCount }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =====================================================
             ASSIGNED ORDERS
        ====================================================== --}}

        <div class="driver-panel">

            <div class="driver-panel-header">

                <div>

                    <span class="section-label">
                        DELIVERIES
                    </span>

                    <h2>
                        My Assigned Orders
                    </h2>

                </div>

            </div>


            @if($assignedOrders->count() > 0)

                <div class="driver-orders-list">

                    @foreach($assignedOrders as $order)

                        <div class="driver-order-card">


                            {{-- =================================================
                                 ORDER HEADER
                            ================================================== --}}

                            <div class="driver-order-top">

                                <div>

                                    <span class="driver-order-label">
                                        ORDER #{{ $order->id }}
                                    </span>

                                    <h3>
                                        {{ $order->full_name }}
                                    </h3>

                                </div>


                                <span class="driver-order-status">
                                    {{ $order->status }}
                                </span>

                            </div>


                            {{-- =================================================
                                 ORDER DETAILS
                            ================================================== --}}

                            <div class="driver-order-details">


                                {{-- DELIVERY ADDRESS --}}

                                <div>

                                    <span>
                                        📍 Delivery Address
                                    </span>

                                    <strong>
                                        {{ $order->address }},
                                        {{ $order->barangay }},
                                        {{ $order->city }}
                                        {{ $order->postal_code }}
                                    </strong>

                                </div>


                                {{-- PHONE --}}

                                <div>

                                    <span>
                                        📞 Phone
                                    </span>

                                    <strong>
                                        {{ $order->phone }}
                                    </strong>

                                </div>


                                {{-- TOTAL --}}

                                <div>

                                    <span>
                                        💰 Total
                                    </span>

                                    <strong>
                                        ₱{{ number_format(
                                            $order->total,
                                            2
                                        ) }}
                                    </strong>

                                </div>


                                {{-- PAYMENT --}}

                                <div>

                                    <span>
                                        💳 Payment
                                    </span>

                                    <strong>
                                        {{ $order->payment_method }}
                                    </strong>

                                </div>

                            </div>


                            {{-- =================================================
                                 DELIVERY NOTES
                            ================================================== --}}

                            @if($order->delivery_notes)

                                <div class="driver-order-notes">

                                    <span>
                                        📝 Delivery Notes
                                    </span>

                                    <p>
                                        {{ $order->delivery_notes }}
                                    </p>

                                </div>

                            @endif


                            {{-- =================================================
                                 DRIVER STATUS ACTIONS
                            ================================================== --}}

                            @if($order->status === 'Ready')

                                <div class="driver-status-action">

                                    <div class="driver-action-message">

                                        <span>
                                            📦 ORDER READY
                                        </span>

                                        <p>
                                            This order is ready for pickup.
                                            Start the delivery when you are ready.
                                        </p>

                                    </div>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'driver.orders.update-status',
                                            $order
                                        ) }}"
                                    >

                                        @csrf

                                        @method('PATCH')


                                        <input
                                            type="hidden"
                                            name="status"
                                            value="Out for Delivery"
                                        >


                                        <button
                                            type="submit"
                                            class="driver-start-delivery-button"
                                        >
                                            🚚 Start Delivery
                                        </button>

                                    </form>

                                </div>


                            @elseif($order->status === 'Out for Delivery')

                                <div class="driver-status-action">

                                    <div class="driver-action-message">

                                        <span>
                                            🚚 DELIVERY IN PROGRESS
                                        </span>

                                        <p>
                                            You are currently delivering
                                            this order.
                                        </p>

                                    </div>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'driver.orders.update-status',
                                            $order
                                        ) }}"
                                        class="delivery-status-form"
                                    >

                                        @csrf

                                        @method('PATCH')


                                        <input
                                            type="hidden"
                                            name="status"
                                            value="Delivered"
                                        >


                                        <button
                                            type="submit"
                                            class="driver-delivered-button"
                                            data-confirm-delivery
                                        >
                                            ✅ Mark as Delivered
                                        </button>

                                    </form>

                                </div>


                            @elseif($order->status === 'Delivered')

                                <div class="driver-completed-message">

                                    <span>
                                        ✅ DELIVERY COMPLETED
                                    </span>

                                    <p>
                                        This order has been delivered
                                        successfully.
                                    </p>

                                </div>


                            @elseif($order->status === 'Completed')

                                <div class="driver-completed-message">

                                    <span>
                                        ✅ ORDER COMPLETED
                                    </span>

                                    <p>
                                        This order has been completed.
                                    </p>

                                </div>


                            @elseif($order->status === 'Cancelled')

                                <div class="driver-cancelled-message">

                                    <span>
                                        ❌ ORDER CANCELLED
                                    </span>

                                    <p>
                                        This order has been cancelled.
                                    </p>

                                </div>


                            @elseif($order->status === 'Pending')

                                <div class="driver-waiting-message">

                                    <span>
                                        ⏳ WAITING FOR ADMIN
                                    </span>

                                    <p>
                                        The order is still pending
                                        confirmation.
                                    </p>

                                </div>


                            @elseif($order->status === 'Confirmed')

                                <div class="driver-waiting-message">

                                    <span>
                                        ⏳ ORDER CONFIRMED
                                    </span>

                                    <p>
                                        Waiting for the order to be
                                        prepared.
                                    </p>

                                </div>


                            @elseif($order->status === 'Preparing')

                                <div class="driver-waiting-message">

                                    <span>
                                        🍳 ORDER BEING PREPARED
                                    </span>

                                    <p>
                                        The restaurant is currently
                                        preparing this order.
                                    </p>

                                </div>

                            @endif


                            {{-- =================================================
                                 DRIVER CANCELLATION
                            ================================================== --}}

                            @if(!in_array($order->status, [
                                'Delivered',
                                'Completed',
                                'Cancelled',
                                'Rejected',
                            ]))

                                <div class="driver-cancel-section">

                                    <button
                                        type="button"
                                        class="driver-cancel-button js-cancel-toggle"
                                        data-order-id="{{ $order->id }}"
                                    >
                                        Cancel Order
                                    </button>


                                    <div
                                        id="cancel-form-{{ $order->id }}"
                                        class="driver-cancel-form"
                                        style="display: none;"
                                    >

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'driver.orders.cancel',
                                                $order
                                            ) }}"
                                            class="driver-cancel-order-form"
                                        >

                                            @csrf

                                            @method('PATCH')


                                            <label
                                                for="reason-{{ $order->id }}"
                                            >
                                                Why do you need to cancel
                                                this order?
                                            </label>


                                            <select
                                                name="cancellation_reason"
                                                id="reason-{{ $order->id }}"
                                                required
                                            >

                                                <option value="">
                                                    Select a reason
                                                </option>


                                                <option value="Unsafe location">
                                                    Unsafe location
                                                </option>


                                                <option value="Customer unavailable">
                                                    Customer unavailable
                                                </option>


                                                <option value="Incorrect or incomplete address">
                                                    Incorrect or incomplete address
                                                </option>


                                                <option value="Customer requested cancellation">
                                                    Customer requested cancellation
                                                </option>


                                                <option value="Vehicle or transportation problem">
                                                    Vehicle or transportation problem
                                                </option>


                                                <option value="Other">
                                                    Other
                                                </option>

                                            </select>


                                            <div class="driver-cancel-actions">

                                                <button
                                                    type="submit"
                                                    class="driver-confirm-cancel-button"
                                                >
                                                    Confirm Cancellation
                                                </button>


                                                <button
                                                    type="button"
                                                    class="driver-cancel-back-button js-cancel-back"
                                                    data-order-id="{{ $order->id }}"
                                                >
                                                    Go Back
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            @endif


                            {{-- =================================================
                                 CANCELLATION INFORMATION
                            ================================================== --}}

                            @if($order->status === 'Cancelled')

                                <div class="driver-order-notes">

                                    <span>
                                        ❌ Cancellation Information
                                    </span>


                                    <p>

                                        <strong>
                                            Reason:
                                        </strong>

                                        {{ $order->cancellation_reason
                                            ?? 'No reason provided.' }}

                                    </p>


                                    @if($order->cancelled_by)

                                        <p>

                                            <strong>
                                                Cancelled By:
                                            </strong>

                                            {{ $order->cancelled_by }}

                                        </p>

                                    @endif


                                    @if($order->cancelled_at)

                                        <p>

                                            <strong>
                                                Cancelled At:
                                            </strong>

                                            {{ $order->cancelled_at }}

                                        </p>

                                    @endif

                                </div>

                            @endif


                            {{-- =================================================
                                 ORDER FOOTER
                            ================================================== --}}

                            <div class="driver-order-footer">

                                <span>
                                    Placed
                                    {{ $order->created_at->format(
                                        'M d, Y h:i A'
                                    ) }}
                                </span>

                            </div>


                        </div>

                    @endforeach

                </div>


            @else

                {{-- EMPTY STATE --}}

                <div class="driver-empty-state">

                    <div class="driver-empty-icon">
                        📦
                    </div>

                    <h3>
                        No deliveries assigned
                    </h3>

                    <p>
                        Orders assigned to you by the admin will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</section>


{{-- =========================================================
     DELIVERY CONFIRMATION MODAL
========================================================== --}}

<div
    id="deliveryConfirmModal"
    class="driver-confirm-modal"
    style="display: none;"
>

    <div class="driver-confirm-overlay"></div>


    <div
        class="driver-confirm-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deliveryConfirmTitle"
    >

        <div class="driver-confirm-icon">
            ✅
        </div>


        <h2 id="deliveryConfirmTitle">
            Confirm Delivery
        </h2>


        <p>
            Are you sure you have delivered this order to the customer?
        </p>


        <div class="driver-confirm-actions">

            <button
                type="button"
                class="driver-confirm-yes"
                id="confirmDeliveryButton"
            >
                ✅ Yes, Delivered
            </button>


            <button
                type="button"
                class="driver-confirm-no"
                id="cancelDeliveryButton"
            >
                Cancel
            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     CANCEL ORDER CONFIRMATION MODAL
========================================================== --}}

<div
    id="cancelConfirmModal"
    class="driver-cancel-confirm-modal"
    style="display: none;"
>

    <div class="driver-cancel-confirm-overlay"></div>


    <div
        class="driver-cancel-confirm-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cancelConfirmTitle"
    >

        <div class="driver-cancel-confirm-icon">
            ⚠️
        </div>


        <h2 id="cancelConfirmTitle">
            Cancel This Order?
        </h2>


        <p>
            Are you sure you want to cancel this order?
        </p>


        <div class="driver-cancel-confirm-actions">

            <button
                type="button"
                class="driver-cancel-confirm-yes"
                id="confirmCancelButton"
            >
                ❌ Cancel Order
            </button>


            <button
                type="button"
                class="driver-cancel-confirm-no"
                id="cancelCancelButton"
            >
                Go Back
            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     DRIVER DASHBOARD JAVASCRIPT
========================================================== --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {

            /*
            |--------------------------------------------------------------------------
            | CANCEL FORM TOGGLE
            |--------------------------------------------------------------------------
            */

            const cancelButtons =
                document.querySelectorAll(
                    '.js-cancel-toggle'
                );


            cancelButtons.forEach(
                function (button)
                {

                    button.addEventListener(
                        'click',
                        function ()
                        {

                            const orderId =
                                this.dataset.orderId;


                            const form =
                                document.getElementById(
                                    'cancel-form-' +
                                    orderId
                                );


                            if (!form) {
                                return;
                            }


                            if (
                                form.style.display ===
                                'none'
                            ) {

                                form.style.display =
                                    'block';

                            } else {

                                form.style.display =
                                    'none';

                            }

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | CANCEL FORM BACK BUTTON
            |--------------------------------------------------------------------------
            */

            const backButtons =
                document.querySelectorAll(
                    '.js-cancel-back'
                );


            backButtons.forEach(
                function (button)
                {

                    button.addEventListener(
                        'click',
                        function ()
                        {

                            const orderId =
                                this.dataset.orderId;


                            const form =
                                document.getElementById(
                                    'cancel-form-' +
                                    orderId
                                );


                            if (!form) {
                                return;
                            }


                            form.style.display =
                                'none';

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | CANCEL ORDER CONFIRMATION MODAL
            |--------------------------------------------------------------------------
            */

            const cancelConfirmModal =
                document.getElementById(
                    'cancelConfirmModal'
                );


            const confirmCancelButton =
                document.getElementById(
                    'confirmCancelButton'
                );


            const cancelCancelButton =
                document.getElementById(
                    'cancelCancelButton'
                );


            const cancelSubmitButtons =
                document.querySelectorAll(
                    '.driver-confirm-cancel-button'
                );


            let selectedCancelForm = null;


            cancelSubmitButtons.forEach(
                function (button)
                {

                    button.addEventListener(
                        'click',
                        function (event)
                        {

                            event.preventDefault();


                            selectedCancelForm =
                                this.closest(
                                    '.driver-cancel-order-form'
                                );


                            if (
                                !cancelConfirmModal
                            ) {
                                return;
                            }


                            cancelConfirmModal.style.display =
                                'flex';


                            document.body.classList.add(
                                'driver-cancel-modal-open'
                            );

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | CONFIRM CANCELLATION
            |--------------------------------------------------------------------------
            */

            if (confirmCancelButton) {

                confirmCancelButton.addEventListener(
                    'click',
                    function ()
                    {

                        if (
                            selectedCancelForm
                        ) {

                            selectedCancelForm.requestSubmit();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLOSE CANCEL MODAL
            |--------------------------------------------------------------------------
            */

            function closeCancelConfirmModal()
            {

                if (cancelConfirmModal) {

                    cancelConfirmModal.style.display =
                        'none';

                }


                document.body.classList.remove(
                    'driver-cancel-modal-open'
                );


                selectedCancelForm = null;

            }


            /*
            |--------------------------------------------------------------------------
            | CANCEL BUTTON
            |--------------------------------------------------------------------------
            */

            if (cancelCancelButton) {

                cancelCancelButton.addEventListener(
                    'click',
                    function ()
                    {

                        closeCancelConfirmModal();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLICK OUTSIDE CANCEL MODAL
            |--------------------------------------------------------------------------
            */

            if (cancelConfirmModal) {

                const cancelOverlay =
                    cancelConfirmModal.querySelector(
                        '.driver-cancel-confirm-overlay'
                    );


                if (cancelOverlay) {

                    cancelOverlay.addEventListener(
                        'click',
                        function ()
                        {

                            closeCancelConfirmModal();

                        }
                    );

                }

            }


            /*
            |--------------------------------------------------------------------------
            | DELIVERY CONFIRMATION MODAL
            |--------------------------------------------------------------------------
            */

            const deliveryModal =
                document.getElementById(
                    'deliveryConfirmModal'
                );


            const confirmDeliveryButton =
                document.getElementById(
                    'confirmDeliveryButton'
                );


            const cancelDeliveryButton =
                document.getElementById(
                    'cancelDeliveryButton'
                );


            const deliveryButtons =
                document.querySelectorAll(
                    '[data-confirm-delivery]'
                );


            let deliveryFormToSubmit = null;


            /*
            |--------------------------------------------------------------------------
            | OPEN DELIVERY MODAL
            |--------------------------------------------------------------------------
            */

            deliveryButtons.forEach(
                function (button)
                {

                    button.addEventListener(
                        'click',
                        function (event)
                        {

                            event.preventDefault();


                            deliveryFormToSubmit =
                                this.closest('form');


                            if (!deliveryModal) {
                                return;
                            }


                            deliveryModal.style.display =
                                'flex';


                            document.body.classList.add(
                                'driver-modal-open'
                            );

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | CONFIRM DELIVERY
            |--------------------------------------------------------------------------
            */

            if (confirmDeliveryButton) {

                confirmDeliveryButton.addEventListener(
                    'click',
                    function ()
                    {

                        if (
                            deliveryFormToSubmit
                        ) {

                            deliveryFormToSubmit.submit();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLOSE DELIVERY MODAL
            |--------------------------------------------------------------------------
            */

            function closeDeliveryModal()
            {

                if (deliveryModal) {

                    deliveryModal.style.display =
                        'none';

                }


                document.body.classList.remove(
                    'driver-modal-open'
                );


                deliveryFormToSubmit = null;

            }


            /*
            |--------------------------------------------------------------------------
            | CANCEL DELIVERY CONFIRMATION
            |--------------------------------------------------------------------------
            */

            if (cancelDeliveryButton) {

                cancelDeliveryButton.addEventListener(
                    'click',
                    function ()
                    {

                        closeDeliveryModal();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLICK OUTSIDE DELIVERY MODAL
            |--------------------------------------------------------------------------
            */

            if (deliveryModal) {

                const deliveryOverlay =
                    deliveryModal.querySelector(
                        '.driver-confirm-overlay'
                    );


                if (deliveryOverlay) {

                    deliveryOverlay.addEventListener(
                        'click',
                        function ()
                        {

                            closeDeliveryModal();

                        }
                    );

                }

            }


            /*
            |--------------------------------------------------------------------------
            | ESCAPE KEY
            |--------------------------------------------------------------------------
            */

            document.addEventListener(
                'keydown',
                function (event)
                {

                    if (
                        event.key === 'Escape'
                    ) {

                        if (
                            deliveryModal &&
                            deliveryModal.style.display ===
                                'flex'
                        ) {

                            closeDeliveryModal();

                        }


                        if (
                            cancelConfirmModal &&
                            cancelConfirmModal.style.display ===
                                'flex'
                        ) {

                            closeCancelConfirmModal();

                        }

                    }

                }
            );

        }
    );

</script>

@endsection