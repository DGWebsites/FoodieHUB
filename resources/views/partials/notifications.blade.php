@if(auth()->check())

    @php

        /*
        |--------------------------------------------------------------------------
        | Remove expired unread notifications
        |--------------------------------------------------------------------------
        | Notifications older than 5 minutes are deleted if they
        | were never opened.
        */

        auth()->user()
            ->unreadNotifications()
            ->where(
                'created_at',
                '<',
                now()->subMinutes(5)
            )
            ->delete();


        $unreadNotifications =
            auth()->user()
                ->unreadNotifications()
                ->latest()
                ->take(6)
                ->get();


        $unreadNotificationCount =
            auth()->user()
                ->unreadNotifications()
                ->count();

    @endphp


    <div class="notification-wrapper">

        <button
            type="button"
            class="notification-button"
            id="notificationButton"
            aria-label="Open notifications"
        >

            🔔


            @if($unreadNotificationCount > 0)

                <span
                    class="notification-badge"
                    id="notificationBadge"
                >
                    {{ $unreadNotificationCount > 99
                        ? '99+'
                        : $unreadNotificationCount }}
                </span>

            @endif

        </button>


        <div
            id="notificationDropdown"
            class="notification-dropdown"
            style="display: none;"
        >

            <div class="notification-dropdown-header">

                <div>

                    <span class="notification-eyebrow">
                        FOODIEHUB
                    </span>

                    <h3>
                        Notifications
                    </h3>

                </div>


                @if($unreadNotificationCount > 0)

                    <form
                        method="POST"
                        action="{{ route(
                            'notifications.read-all'
                        ) }}"
                    >

                        @csrf

                        @method('PATCH')

                        <button
                            type="submit"
                            class="notification-read-all"
                        >
                            Mark all as read
                        </button>

                    </form>

                @endif

            </div>


            <div
                class="notification-list"
                id="notificationList"
            >

                @if($unreadNotifications->isEmpty())

                    <div
                        class="notification-empty"
                        id="notificationEmpty"
                    >

                        <div class="notification-empty-icon">
                            🔔
                        </div>

                        <strong>
                            No new notifications
                        </strong>

                        <p>
                            You're all caught up.
                        </p>

                    </div>

                @else

                    @foreach($unreadNotifications as $notification)

                        @php

                            $notificationTime =
                                $notification->created_at
                                    ->timestamp;

                            $notificationTitle =
                                $notification->data['title']
                                    ?? 'Notification';

                            $notificationMessage =
                                $notification->data['message']
                                    ?? '';

                            $notificationType =
                                $notification->data['type']
                                    ?? 'order';

                        @endphp


                        <a
                            href="{{ route(
                                'notifications.open',
                                $notification->id
                            ) }}"
                            class="notification-item js-notification-item"
                            data-created-at="{{ $notificationTime }}"
                        >

                            <div class="notification-item-icon">

                                @if($notificationType === 'driver')

                                    🚚

                                @elseif($notificationType === 'warning')

                                    ⚠️

                                @elseif($notificationType === 'success')

                                    ✅

                                @else

                                    🔔

                                @endif

                            </div>


                            <div class="notification-item-content">

                                <strong>
                                    {{ $notificationTitle }}
                                </strong>


                                <p>
                                    {{ $notificationMessage }}
                                </p>


                                <span>
                                    {{ $notification->created_at
                                        ->diffForHumans() }}
                                </span>


                                <small
                                    class="notification-expiry"
                                >
                                    Expires in 5:00
                                </small>

                            </div>

                        </a>

                    @endforeach

                @endif

            </div>

        </div>

    </div>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function ()
            {

                /*
                |--------------------------------------------------------------------------
                | Notification Dropdown
                |--------------------------------------------------------------------------
                */

                const button =
                    document.getElementById(
                        'notificationButton'
                    );


                const dropdown =
                    document.getElementById(
                        'notificationDropdown'
                    );


                if (
                    button &&
                    dropdown
                ) {

                    button.addEventListener(
                        'click',
                        function (event)
                        {

                            event.stopPropagation();


                            if (
                                dropdown.style.display ===
                                'none'
                            ) {

                                dropdown.style.display =
                                    'block';

                            } else {

                                dropdown.style.display =
                                    'none';

                            }

                        }
                    );


                    document.addEventListener(
                        'click',
                        function (event)
                        {

                            if (
                                !dropdown.contains(
                                    event.target
                                ) &&
                                !button.contains(
                                    event.target
                                )
                            ) {

                                dropdown.style.display =
                                    'none';

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Five Minute Expiration
                |--------------------------------------------------------------------------
                */

                const notificationItems =
                    document.querySelectorAll(
                        '.js-notification-item'
                    );


                const expirationTime =
                    5 * 60 * 1000;


                notificationItems.forEach(
                    function (item)
                    {

                        const createdAt =
                            Number(
                                item.dataset.createdAt
                            ) * 1000;


                        function updateNotificationTimer()
                        {

                            const now =
                                Date.now();


                            const remaining =
                                expirationTime -
                                (now - createdAt);


                            if (
                                remaining <= 0
                            ) {

                                removeNotification(
                                    item
                                );

                                return;

                            }


                            const totalSeconds =
                                Math.floor(
                                    remaining / 1000
                                );


                            const minutes =
                                Math.floor(
                                    totalSeconds / 60
                                );


                            const seconds =
                                totalSeconds % 60;


                            const expiry =
                                item.querySelector(
                                    '.notification-expiry'
                                );


                            if (expiry) {

                                expiry.textContent =
                                    'Expires in ' +
                                    minutes +
                                    ':' +
                                    String(
                                        seconds
                                    ).padStart(
                                        2,
                                        '0'
                                    );

                            }

                        }


                        updateNotificationTimer();


                        const timer =
                            setInterval(
                                function ()
                                {

                                    if (
                                        !document.body.contains(
                                            item
                                        )
                                    ) {

                                        clearInterval(
                                            timer
                                        );

                                        return;

                                    }


                                    updateNotificationTimer();

                                },
                                1000
                            );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Remove Expired Notification
                |--------------------------------------------------------------------------
                */

                function removeNotification(item)
                {

                    item.remove();


                    updateNotificationBadge();


                    const list =
                        document.getElementById(
                            'notificationList'
                        );


                    if (
                        list &&
                        !list.querySelector(
                            '.js-notification-item'
                        )
                    ) {

                        list.innerHTML = `

                            <div
                                class="notification-empty"
                            >

                                <div
                                    class="notification-empty-icon"
                                >
                                    🔔
                                </div>

                                <strong>
                                    No new notifications
                                </strong>

                                <p>
                                    You're all caught up.
                                </p>

                            </div>

                        `;

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Update Notification Badge
                |--------------------------------------------------------------------------
                */

                function updateNotificationBadge()
                {

                    const badge =
                        document.getElementById(
                            'notificationBadge'
                        );


                    if (!badge) {
                        return;
                    }


                    const remaining =
                        document.querySelectorAll(
                            '.js-notification-item'
                        ).length;


                    if (
                        remaining <= 0
                    ) {

                        badge.remove();

                        return;

                    }


                    badge.textContent =
                        remaining > 99
                            ? '99+'
                            : remaining;

                }

            }
        );

    </script>

@endif