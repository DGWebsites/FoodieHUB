@extends('layouts.app')

@section('content')

<section class="fh-status-page">

    <div class="fh-status-container">


        {{-- PAGE HEADER --}}

        <div class="fh-status-header">

            <span class="section-label">
                FOODIEHUB STATUS
            </span>

            <h1>
                Store Status
            </h1>

            <p>
                Check whether FoodieHub is currently accepting new orders.
            </p>

        </div>


        {{-- MAIN STATUS CARD --}}

        <div
            class="fh-status-card
            {{ $isOpen ? 'fh-status-live-card' : 'fh-status-closed-card' }}"
        >


            {{-- ICON --}}

            <div
                class="fh-status-icon
                {{ $isOpen ? 'fh-status-live-icon' : 'fh-status-closed-icon' }}"
            >
                {{ $isOpen ? '🟢' : '🔴' }}
            </div>


            {{-- CURRENT STATUS LABEL --}}

            <span
                class="fh-status-current-label
                {{ $isOpen ? 'fh-status-current-live' : 'fh-status-current-closed' }}"
            >
                CURRENT STATUS
            </span>


            {{-- LIVE STATUS --}}

            @if($isOpen)

                <h2>
                    FoodieHub is LIVE
                </h2>

                <p class="fh-status-description">
                    Our store is currently open and accepting new orders.
                    Browse the menu and place your order now.
                </p>


                <div class="fh-status-indicator fh-status-indicator-live">

                    <span class="fh-status-dot"></span>

                    <span>
                        OPEN — Accepting Orders
                    </span>

                </div>


                <a
                    href="{{ route('home') }}"
                    class="fh-status-primary-button"
                >
                    Browse Menu →
                </a>


            {{-- CLOSED STATUS --}}

            @else

                <h2>
                    FoodieHub is CLOSED
                </h2>

                <p class="fh-status-description">
                    Our store is currently closed and is not accepting
                    new orders at this time.
                </p>


                <div class="fh-status-indicator fh-status-indicator-closed">

                    <span class="fh-status-dot"></span>

                    <span>
                        CLOSED — Orders Disabled
                    </span>

                </div>


                <a
                    href="{{ route('home') }}"
                    class="fh-status-secondary-button"
                >
                    Browse Menu →
                </a>

            @endif

        </div>


        {{-- INFORMATION CARDS --}}

        <div class="fh-status-info-grid">


            {{-- BROWSE FOOD --}}

            <div class="fh-status-info-card">

                <div class="fh-status-info-icon">
                    🍔
                </div>

                <div>

                    <h3>
                        Browse Food
                    </h3>

                    <p>
                        You can still view FoodieHub's menu
                        even when the store is closed.
                    </p>

                </div>

            </div>


            {{-- PLACE ORDERS --}}

            <div class="fh-status-info-card">

                <div class="fh-status-info-icon">
                    🛒
                </div>

                <div>

                    <h3>
                        Place Orders
                    </h3>

                    <p>

                        @if($isOpen)

                            New orders are currently being accepted.

                        @else

                            New orders are temporarily disabled.

                        @endif

                    </p>

                </div>

            </div>


            {{-- CHECK AGAIN --}}

            <div class="fh-status-info-card">

                <div class="fh-status-info-icon">
                    ⏰
                </div>

                <div>

                    <h3>
                        Check Again
                    </h3>

                    <p>
                        Store availability can change at any time.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<style>

/* =========================================================
   STATUS PAGE
========================================================= */

.fh-status-page {
    min-height: calc(100vh - 180px);

    padding: 60px 20px 85px;

    background: #0b0d0c;

    color: #ffffff;

    box-sizing: border-box;
}


/* =========================================================
   CENTER CONTAINER
========================================================= */

.fh-status-container {

    width: 100%;

    max-width: 950px;

    margin: 0 auto;

    display: flex;

    flex-direction: column;

    align-items: center;

    text-align: center;
}


/* =========================================================
   HEADER
========================================================= */

.fh-status-header {

    width: 100%;

    margin-bottom: 32px;
}


.fh-status-header h1 {

    margin: 8px 0 8px;

    color: #ffffff;

    font-size: 40px;

    line-height: 1.1;

    font-weight: 800;

    letter-spacing: -0.9px;
}


.fh-status-header p {

    margin: 0;

    color: #8f9a92;

    font-size: 14px;

    line-height: 1.6;
}


/* =========================================================
   MAIN STATUS CARD
========================================================= */

.fh-status-card {

    width: 100%;

    max-width: 760px;

    padding: 42px 32px;

    box-sizing: border-box;

    background: #111413;

    border-radius: 22px;

    text-align: center;

    box-shadow:
        0 20px 50px rgba(0, 0, 0, 0.35);
}


/* LIVE */

.fh-status-live-card {

    border: 1px solid rgba(34, 197, 94, 0.28);
}


/* CLOSED */

.fh-status-closed-card {

    border: 1px solid rgba(239, 68, 68, 0.28);
}


/* =========================================================
   STATUS ICON
========================================================= */

.fh-status-icon {

    width: 76px;

    height: 76px;

    margin: 0 auto 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 20px;

    font-size: 32px;
}


/* LIVE ICON */

.fh-status-live-icon {

    background: rgba(34, 197, 94, 0.10);

    border: 1px solid rgba(34, 197, 94, 0.22);
}


/* CLOSED ICON */

.fh-status-closed-icon {

    background: rgba(239, 68, 68, 0.10);

    border: 1px solid rgba(239, 68, 68, 0.22);
}


/* =========================================================
   CURRENT STATUS LABEL
========================================================= */

.fh-status-current-label {

    display: block;

    margin-bottom: 8px;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 0.10em;
}


/* LIVE LABEL */

.fh-status-current-live {

    color: #22c55e;
}


/* CLOSED LABEL */

.fh-status-current-closed {

    color: #f87171;
}


/* =========================================================
   MAIN TITLE
========================================================= */

.fh-status-card h2 {

    margin: 0 0 12px;

    color: #ffffff;

    font-size: 30px;

    line-height: 1.2;

    font-weight: 800;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.fh-status-description {

    max-width: 560px;

    margin: 0 auto;

    color: #9ca6a0;

    font-size: 14px;

    line-height: 1.7;
}


/* =========================================================
   STATUS INDICATOR
========================================================= */

.fh-status-indicator {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    margin-top: 22px;

    min-height: 40px;

    padding: 0 16px;

    border-radius: 999px;

    font-size: 12px;

    font-weight: 800;
}


/* LIVE */

.fh-status-indicator-live {

    background: rgba(34, 197, 94, 0.10);

    border: 1px solid rgba(34, 197, 94, 0.20);

    color: #4ade80;
}


/* CLOSED */

.fh-status-indicator-closed {

    background: rgba(239, 68, 68, 0.10);

    border: 1px solid rgba(239, 68, 68, 0.20);

    color: #f87171;
}


/* STATUS DOT */

.fh-status-dot {

    width: 8px;

    height: 8px;

    border-radius: 50%;

    background: currentColor;
}


/* =========================================================
   BUTTONS
========================================================= */

.fh-status-primary-button,
.fh-status-secondary-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 46px;

    margin-top: 24px;

    padding: 0 21px;

    border-radius: 11px;

    text-decoration: none;

    font-size: 13px;

    font-weight: 800;

    transition: 0.2s ease;
}


/* LIVE BUTTON */

.fh-status-primary-button {

    border: 1px solid #22c55e;

    background: #22c55e;

    color: #061009;
}


.fh-status-primary-button:hover {

    background: #16a34a;

    border-color: #16a34a;

    color: #ffffff;
}


/* CLOSED BUTTON */

.fh-status-secondary-button {

    border: 1px solid #344038;

    background: #0d100e;

    color: #ffffff;
}


.fh-status-secondary-button:hover {

    background: #151a17;

    border-color: #4a574f;

    color: #ffffff;
}


/* =========================================================
   INFORMATION GRID
========================================================= */

.fh-status-info-grid {

    width: 100%;

    max-width: 760px;

    margin-top: 22px;

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 14px;
}


/* =========================================================
   INFORMATION CARD
========================================================= */

.fh-status-info-card {

    display: flex;

    align-items: flex-start;

    gap: 13px;

    padding: 19px;

    box-sizing: border-box;

    background: #111413;

    border: 1px solid #1f2a24;

    border-radius: 15px;

    text-align: left;
}


/* =========================================================
   INFORMATION ICON
========================================================= */

.fh-status-info-icon {

    width: 42px;

    height: 42px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #151a17;

    font-size: 18px;
}


/* =========================================================
   INFORMATION TEXT
========================================================= */

.fh-status-info-card h3 {

    margin: 1px 0 5px;

    color: #ffffff;

    font-size: 14px;

    font-weight: 800;
}


.fh-status-info-card p {

    margin: 0;

    color: #8f9a92;

    font-size: 12px;

    line-height: 1.6;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 750px) {

    .fh-status-page {

        padding-left: 16px;

        padding-right: 16px;
    }


    .fh-status-header h1 {

        font-size: 32px;
    }


    .fh-status-card {

        padding: 32px 20px;
    }


    .fh-status-card h2 {

        font-size: 25px;
    }


    .fh-status-info-grid {

        grid-template-columns: 1fr;
    }

}

</style>

@endsection