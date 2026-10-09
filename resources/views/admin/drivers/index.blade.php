@extends('layouts.app')

@section('content')

<section class="admin-drivers-section">

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

            <div class="driver-success-message">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR MESSAGE --}}

        @if($errors->any())

            <div class="driver-error-message">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="admin-drivers-header">

            <div>

                <span class="section-label">
                    ADMIN PANEL
                </span>

                <h1>
                    Driver Management
                </h1>

                <p>
                    Manage the delivery drivers who handle FoodieHub orders.
                </p>

            </div>


            <a
                href="{{ route('admin.drivers.create') }}"
                class="admin-add-driver-button"
            >
                + Add Driver
            </a>

        </div>


        {{-- =====================================================
             DRIVER SUMMARY
        ====================================================== --}}

        <div class="admin-driver-summary">

            <div class="admin-driver-summary-card">

                <div class="admin-driver-summary-icon">
                    🚚
                </div>

                <div>

                    <span>
                        Total Drivers
                    </span>

                    <strong>
                        {{ $drivers->count() }}
                    </strong>

                </div>

            </div>


            <div class="admin-driver-summary-card">

                <div class="admin-driver-summary-icon">
                    🟢
                </div>

                <div>

                    <span>
                        Active Drivers
                    </span>

                    <strong>
                        {{ $drivers->where('is_active', true)->count() }}
                    </strong>

                </div>

            </div>


            <div class="admin-driver-summary-card">

                <div class="admin-driver-summary-icon">
                    ⚫
                </div>

                <div>

                    <span>
                        Inactive Drivers
                    </span>

                    <strong>
                        {{ $drivers->where('is_active', false)->count() }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =====================================================
             DRIVER LIST
        ====================================================== --}}

        <div class="admin-drivers-panel">

            <div class="admin-drivers-panel-header">

                <div>

                    <span class="section-label">
                        DELIVERY TEAM
                    </span>

                    <h2>
                        Registered Drivers
                    </h2>

                </div>

            </div>


            @if($drivers->count() > 0)

                <div class="admin-driver-list">

                    @foreach($drivers as $driver)

                        <div class="admin-driver-list-card">


                            {{-- DRIVER ICON --}}

                            <div class="admin-driver-avatar">
                                🚚
                            </div>


                            {{-- DRIVER INFORMATION --}}

                            <div class="admin-driver-info">

                                <h3>
                                    {{ $driver->name }}
                                </h3>

                                <p>
                                    {{ $driver->email }}
                                </p>

                                <span class="admin-driver-role">
                                    Delivery Driver
                                </span>

                            </div>


                          {{-- ACCOUNT CREATED --}}

<div class="admin-driver-date">

    <span>
        Account Created
    </span>

    <strong>
        {{ $driver->created_at->format('M d, Y') }}
    </strong>

</div>


{{-- CURRENT DELIVERIES --}}

<div class="admin-driver-workload">

    <span>
        Current Deliveries
    </span>

    <strong>
        {{ number_format($driver->active_orders_count) }}
    </strong>

</div>


{{-- STATUS + ACTION --}}

<div class="admin-driver-status-column">

    @if($driver->is_active)

        <span class="admin-driver-active-badge">
            🟢 Active
        </span>

    @else

        <span class="admin-driver-inactive-badge">
            ⚫ Inactive
        </span>

    @endif


    <form
        method="POST"
        action="{{ route(
            'admin.drivers.toggle-status',
            $driver
        ) }}"
        class="admin-driver-status-form"
        data-driver-name="{{ $driver->name }}"
        data-current-status="{{ $driver->is_active
            ? 'active'
            : 'inactive' }}"
    >

        @csrf

        @method('PATCH')


        @if($driver->is_active)

            <button
                type="submit"
                class="admin-driver-deactivate-button"
                data-toggle-driver
            >
                Deactivate
            </button>

        @else

            <button
                type="submit"
                class="admin-driver-activate-button"
                data-toggle-driver
            >
                Activate
            </button>

        @endif

    </form>

</div>

                        </div>

                    @endforeach

                </div>


            @else

                <div class="admin-drivers-empty">

                    <div class="admin-drivers-empty-icon">
                        🚚
                    </div>

                    <h3>
                        No drivers found
                    </h3>

                    <p>
                        Create a driver account to start assigning deliveries.
                    </p>


                    <a
                        href="{{ route('admin.drivers.create') }}"
                        class="admin-add-driver-button"
                    >
                        + Add First Driver
                    </a>

                </div>

            @endif

        </div>

    </div>

</section>


{{-- =========================================================
     DRIVER STATUS CONFIRMATION MODAL
========================================================== --}}

<div
    id="driverStatusModal"
    class="admin-driver-confirm-modal"
    style="display: none;"
>

    <div class="admin-driver-confirm-overlay"></div>


    <div
        class="admin-driver-confirm-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="driverStatusModalTitle"
    >

        <div
            id="driverStatusModalIcon"
            class="admin-driver-confirm-icon"
        >
            ⚠️
        </div>


        <h2 id="driverStatusModalTitle">
            Deactivate Driver
        </h2>


        <p id="driverStatusModalMessage">
            Are you sure you want to deactivate this driver?
        </p>


        <div class="admin-driver-confirm-actions">

            <button
                type="button"
                id="driverStatusConfirmButton"
                class="admin-driver-confirm-deactivate"
            >
                Deactivate
            </button>


            <button
                type="button"
                id="driverStatusCancelButton"
                class="admin-driver-confirm-cancel"
            >
                Cancel
            </button>

        </div>

    </div>

</div>


<script>

    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {

            const statusModal =
                document.getElementById(
                    'driverStatusModal'
                );


            const statusModalIcon =
                document.getElementById(
                    'driverStatusModalIcon'
                );


            const statusModalTitle =
                document.getElementById(
                    'driverStatusModalTitle'
                );


            const statusModalMessage =
                document.getElementById(
                    'driverStatusModalMessage'
                );


            const confirmButton =
                document.getElementById(
                    'driverStatusConfirmButton'
                );


            const cancelButton =
                document.getElementById(
                    'driverStatusCancelButton'
                );


            const overlay =
                statusModal
                    ? statusModal.querySelector(
                        '.admin-driver-confirm-overlay'
                    )
                    : null;


            let selectedForm = null;


            /*
            |--------------------------------------------------------------------------
            | Open Status Confirmation Modal
            |--------------------------------------------------------------------------
            */

            const statusButtons =
                document.querySelectorAll(
                    '[data-toggle-driver]'
                );


            statusButtons.forEach(
                function (button)
                {

                    button.addEventListener(
                        'click',
                        function (event)
                        {

                            event.preventDefault();


                            const form =
                                this.closest(
                                    '.admin-driver-status-form'
                                );


                            if (!form) {
                                return;
                            }


                            selectedForm = form;


                            const driverName =
                                form.dataset.driverName;


                            const currentStatus =
                                form.dataset.currentStatus;


                            if (
                                currentStatus ===
                                'active'
                            ) {

                                statusModalIcon.textContent =
                                    '⚠️';

                                statusModalIcon.classList.remove(
                                    'activate'
                                );

                                statusModalIcon.classList.add(
                                    'deactivate'
                                );


                                statusModalTitle.textContent =
                                    'Deactivate Driver';


                                statusModalMessage.textContent =
                                    'Are you sure you want to deactivate ' +
                                    driverName +
                                    '? This driver will no longer be available for new order assignments.';


                                confirmButton.textContent =
                                    'Deactivate';


                                confirmButton.classList.remove(
                                    'admin-driver-confirm-activate'
                                );

                                confirmButton.classList.add(
                                    'admin-driver-confirm-deactivate'
                                );

                            } else {

                                statusModalIcon.textContent =
                                    '✅';

                                statusModalIcon.classList.remove(
                                    'deactivate'
                                );

                                statusModalIcon.classList.add(
                                    'activate'
                                );


                                statusModalTitle.textContent =
                                    'Activate Driver';


                                statusModalMessage.textContent =
                                    'Are you sure you want to activate ' +
                                    driverName +
                                    '? This driver will become available for new order assignments.';


                                confirmButton.textContent =
                                    'Activate';


                                confirmButton.classList.remove(
                                    'admin-driver-confirm-deactivate'
                                );

                                confirmButton.classList.add(
                                    'admin-driver-confirm-activate'
                                );

                            }


                            statusModal.style.display =
                                'flex';


                            document.body.classList.add(
                                'admin-driver-modal-open'
                            );

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Confirm Status Change
            |--------------------------------------------------------------------------
            */

            if (confirmButton) {

                confirmButton.addEventListener(
                    'click',
                    function ()
                    {

                        if (selectedForm) {

                            selectedForm.submit();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Close Modal
            |--------------------------------------------------------------------------
            */

            function closeStatusModal()
            {

                if (statusModal) {

                    statusModal.style.display =
                        'none';

                }


                document.body.classList.remove(
                    'admin-driver-modal-open'
                );


                selectedForm = null;

            }


            /*
            |--------------------------------------------------------------------------
            | Cancel Button
            |--------------------------------------------------------------------------
            */

            if (cancelButton) {

                cancelButton.addEventListener(
                    'click',
                    function ()
                    {

                        closeStatusModal();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Overlay Click
            |--------------------------------------------------------------------------
            */

            if (overlay) {

                overlay.addEventListener(
                    'click',
                    function ()
                    {

                        closeStatusModal();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Escape Key
            |--------------------------------------------------------------------------
            */

            document.addEventListener(
                'keydown',
                function (event)
                {

                    if (
                        event.key === 'Escape' &&
                        statusModal &&
                        statusModal.style.display ===
                            'flex'
                    ) {

                        closeStatusModal();

                    }

                }
            );

        }
    );

</script>

@endsection

