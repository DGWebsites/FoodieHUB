@extends('layouts.app')

@section('content')

<section class="fh-store-status-section">

    <div class="container">

        <a
            href="{{ route('admin.dashboard') }}"
            class="fh-store-status-back"
        >
            ← Back to Dashboard
        </a>


        @if(session('success'))

            <div class="fh-store-status-success">
                {{ session('success') }}
            </div>

        @endif


        <div class="fh-store-status-header">

            <span class="section-label">
                ADMIN PANEL
            </span>

            <h1>
                Store Status
            </h1>

            <p>
                Control whether FoodieHub is currently accepting new orders.
            </p>

        </div>


        <div class="fh-store-status-card">

            <div class="fh-store-status-card-top">

                <div class="fh-store-status-icon">
                    🏪
                </div>

                <div>

                    <span class="fh-store-status-label">
                        CURRENT STORE STATUS
                    </span>

                    @if($setting->is_open)

                        <h2>
                            FoodieHub is LIVE
                        </h2>

                        <p>
                            Customers can browse the menu and place new orders.
                        </p>

                    @else

                        <h2>
                            FoodieHub is CLOSED
                        </h2>

                        <p>
                            Customers can browse the menu, but new orders are disabled.
                        </p>

                    @endif

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('admin.store-status.update') }}"
                class="fh-store-status-form"
            >

                @csrf
                @method('PATCH')


                <div class="fh-store-status-options">

                    <label
                        class="fh-store-status-option
                        {{ $setting->is_open ? 'selected-live' : '' }}"
                    >

                        <div class="fh-store-status-option-icon">
                            🟢
                        </div>

                        <div class="fh-store-status-option-text">

                            <strong>
                                LIVE
                            </strong>

                            <span>
                                Accept new orders
                            </span>

                        </div>

                        <input
                            type="radio"
                            name="status"
                            value="live"
                            {{ $setting->is_open ? 'checked' : '' }}
                        >

                    </label>


                    <label
                        class="fh-store-status-option
                        {{ !$setting->is_open ? 'selected-closed' : '' }}"
                    >

                        <div class="fh-store-status-option-icon">
                            🔴
                        </div>

                        <div class="fh-store-status-option-text">

                            <strong>
                                CLOSED
                            </strong>

                            <span>
                                Stop new orders
                            </span>

                        </div>

                        <input
                            type="radio"
                            name="status"
                            value="closed"
                            {{ !$setting->is_open ? 'checked' : '' }}
                        >

                    </label>

                </div>


                <button
                    type="submit"
                    class="fh-store-status-save"
                >
                    Save Store Status
                </button>

            </form>

        </div>

    </div>

</section>


<style>

.fh-store-status-section {
    min-height: calc(100vh - 180px);
    padding: 55px 20px 80px;
    background: #0b0d0c;
    color: #ffffff;
}

.fh-store-status-back {
    display: inline-flex;
    margin-bottom: 25px;
    color: #8f9a92;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.fh-store-status-back:hover {
    color: #22c55e;
}

.fh-store-status-success {
    margin-bottom: 25px;
    padding: 14px 17px;
    border: 1px solid rgba(34, 197, 94, 0.25);
    border-radius: 12px;
    background: rgba(34, 197, 94, 0.08);
    color: #4ade80;
    font-size: 13px;
    font-weight: 700;
}

.fh-store-status-header {
    margin-bottom: 30px;
}

.fh-store-status-header h1 {
    margin: 7px 0 8px;
    color: #ffffff;
    font-size: 38px;
    font-weight: 800;
    letter-spacing: -0.8px;
}

.fh-store-status-header p {
    margin: 0;
    color: #8f9a92;
    font-size: 14px;
}

.fh-store-status-card {
    max-width: 760px;
    padding: 30px;
    box-sizing: border-box;
    background: #111413;
    border: 1px solid #1f2a24;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.30);
}

.fh-store-status-card-top {
    display: flex;
    align-items: center;
    gap: 18px;
    padding-bottom: 25px;
    border-bottom: 1px solid #263129;
}

.fh-store-status-icon {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    background: rgba(34, 197, 94, 0.10);
    border: 1px solid rgba(34, 197, 94, 0.20);
    font-size: 27px;
}

.fh-store-status-label {
    display: block;
    margin-bottom: 5px;
    color: #22c55e;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
}

.fh-store-status-card-top h2 {
    margin: 0 0 5px;
    color: #ffffff;
    font-size: 22px;
}

.fh-store-status-card-top p {
    margin: 0;
    color: #8f9a92;
    font-size: 13px;
    line-height: 1.6;
}

.fh-store-status-form {
    padding-top: 25px;
}

.fh-store-status-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.fh-store-status-option {
    display: flex;
    align-items: center;
    gap: 13px;
    min-height: 92px;
    padding: 18px;
    box-sizing: border-box;
    border: 1px solid #2a362f;
    border-radius: 15px;
    background: #0d100e;
    cursor: pointer;
}

.fh-store-status-option.selected-live {
    border-color: rgba(34, 197, 94, 0.55);
    background: rgba(34, 197, 94, 0.08);
}

.fh-store-status-option.selected-closed {
    border-color: rgba(239, 68, 68, 0.55);
    background: rgba(239, 68, 68, 0.08);
}

.fh-store-status-option-icon {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #151a17;
    font-size: 19px;
}

.fh-store-status-option-text {
    flex: 1;
}

.fh-store-status-option-text strong {
    display: block;
    margin-bottom: 4px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 800;
}

.fh-store-status-option-text span {
    display: block;
    color: #8f9a92;
    font-size: 12px;
}

.fh-store-status-option input {
    width: 18px;
    height: 18px;
    margin: 0;
    cursor: pointer;
}

.fh-store-status-save {
    width: 100%;
    min-height: 48px;
    margin-top: 18px;
    border: 1px solid #22c55e;
    border-radius: 12px;
    background: #22c55e;
    color: #061009;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
}

.fh-store-status-save:hover {
    background: #16a34a;
    border-color: #16a34a;
    color: #ffffff;
}

@media (max-width: 650px) {

    .fh-store-status-section {
        padding-left: 16px;
        padding-right: 16px;
    }

    .fh-store-status-card {
        padding: 22px 18px;
    }

    .fh-store-status-card-top {
        align-items: flex-start;
    }

    .fh-store-status-options {
        grid-template-columns: 1fr;
    }

    .fh-store-status-header h1 {
        font-size: 30px;
    }

}

</style>

@endsection