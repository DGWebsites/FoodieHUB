<div id="foodiehubAssistant">

   
 {{-- Floating Chat Button --}}
<button
    type="button"
    class="fh-assistant-fab"
    id="fhAssistantOpen"
    aria-label="Open FoodieHub Assistant"
>
    <svg
        class="fh-chat-icon"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M7 18.5C4.79 18.5 3 16.71 3 14.5V8.5C3 6.29 4.79 4.5 7 4.5H17C19.21 4.5 21 6.29 21 8.5V14.5C21 16.71 19.21 18.5 17 18.5H10L6 21V18.5H7Z"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linejoin="round"
        />
    </svg>

    <span>
        Chat
    </span>
</button>


    {{-- Chat Window --}}
    <div
        class="fh-assistant-window"
        id="fhAssistantWindow"
    >

        {{-- Header --}}
        <div class="fh-assistant-header">

            <div class="fh-assistant-profile">

                <div class="fh-assistant-avatar">
                    🍴
                </div>

                <div>

                    <div class="fh-assistant-name">
                        FoodieHub Assistant
                    </div>

                    <div class="fh-assistant-online">
                        <span></span>
                        Online
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="fh-assistant-close"
                id="fhAssistantClose"
                aria-label="Close assistant"
            >
                ×
            </button>

        </div>


        {{-- Chat Body --}}
        <div
            class="fh-assistant-body"
            id="fhAssistantBody"
        >

            {{-- Greeting --}}
            <div class="fh-message fh-message-bot">

                <div class="fh-message-bubble">

                    Hi, I'm the FoodieHub assistant.
                    What can I help you with?

                </div>

                <div class="fh-message-name">
                    FoodieHub Assistant
                </div>

            </div>


            {{-- Popular Questions --}}
            <div class="fh-popular-title">
                POPULAR QUESTIONS
            </div>


            <div
                class="fh-question-list"
                id="fhQuestionList"
            >

                <button
                    type="button"
                    class="fh-question"
                    data-question="How long does delivery take?"
                >
                    How long does delivery take?
                </button>


                <button
                    type="button"
                    class="fh-question"
                    data-question="How do I receive my order?"
                >
                    How do I receive my order?
                </button>


                <button
                    type="button"
                    class="fh-question"
                    data-question="Is FoodieHub legit?"
                >
                    Is FoodieHub legit?
                </button>


                <button
                    type="button"
                    class="fh-question"
                    data-question="What payment methods do you accept?"
                >
                    What payment methods do you accept?
                </button>


                <button
                    type="button"
                    class="fh-question"
                    data-question="Do you have promo codes?"
                >
                    Do you have promo codes?
                </button>


                <button
                    type="button"
                    class="fh-question"
                    data-question="I didn't receive my order"
                >
                    I didn't receive my order
                </button>

            </div>

        </div>


        {{-- Footer --}}
        <div class="fh-assistant-footer">

            <div class="fh-input-row">

                <input
                    type="text"
                    id="fhAssistantInput"
                    class="fh-assistant-input"
                    placeholder="Type your message..."
                    autocomplete="off"
                >


                <button
                    type="button"
                    id="fhAssistantSend"
                    class="fh-assistant-send"
                    aria-label="Send message"
                >
                    ➤
                </button>

            </div>


            <a
                href="{{ route('support') }}"
                class="fh-message-team"
            >
                Message the team instead
            </a>

        </div>

    </div>

</div>


<style>

/* =========================================================
   FOODIEHUB ASSISTANT
========================================================= */

#foodiehubAssistant {
    position: relative;
    z-index: 9999;
}


/* Floating Button */

.fh-assistant-fab {

    position: fixed;

    right: 24px;
    bottom: 24px;

    width: 58px;
    height: 58px;

    border: 1px solid #22c55e;
    border-radius: 50%;

    background: #111713;
    color: #22c55e;

    font-size: 24px;

    cursor: pointer;

    box-shadow:
        0 12px 30px rgba(0,0,0,.35);

    transition: .2s ease;

}


.fh-assistant-fab:hover {

    background: #22c55e;
    color: #061009;

    transform: translateY(-2px);

}


/* Chat Window */

.fh-assistant-window {

    position: fixed;

    right: 24px;
    bottom: 24px;

    width: 360px;
    max-width: calc(100vw - 32px);

    height: 540px;

    display: flex;
    flex-direction: column;

    overflow: hidden;

    background: #090c0b;

    border: 1px solid #27332c;
    border-radius: 20px;

    box-shadow:
        0 25px 70px rgba(0,0,0,.55);

    opacity: 0;
    visibility: hidden;

    transform:
        translateY(20px)
        scale(.97);

    transition:
        opacity .2s ease,
        transform .2s ease,
        visibility .2s ease;

}


.fh-assistant-window.open {

    opacity: 1;
    visibility: visible;

    transform:
        translateY(0)
        scale(1);

}


/* Header */

.fh-assistant-header {

    display: flex;

    align-items: center;
    justify-content: space-between;

    padding: 16px;

    background: #171c22;

    border-bottom: 1px solid #27332c;

}


.fh-assistant-profile {

    display: flex;

    align-items: center;

    gap: 10px;

}


.fh-assistant-avatar {

    width: 40px;
    height: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #102719;

    border: 1px solid #20b85a;

    font-size: 19px;

}


.fh-assistant-name {

    color: #f5f7f6;

    font-size: 14px;

    font-weight: 800;

}


.fh-assistant-online {

    display: flex;

    align-items: center;

    gap: 5px;

    margin-top: 2px;

    color: #22c55e;

    font-size: 11px;

}


.fh-assistant-online span {

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #22c55e;

}


.fh-assistant-close {

    width: 30px;
    height: 30px;

    border: none;

    background: transparent;

    color: #8d9691;

    font-size: 25px;

    cursor: pointer;

}


.fh-assistant-close:hover {

    color: #ffffff;

}


/* Body */

.fh-assistant-body {

    flex: 1;

    overflow-y: auto;

    padding: 14px 16px 20px;

    background: #090c0b;

}


/* Messages */

.fh-message {

    display: flex;

    flex-direction: column;

    margin-bottom: 14px;

}


.fh-message-user {

    align-items: flex-end;

}


.fh-message-bot {

    align-items: flex-start;

}


.fh-message-bubble {

    max-width: 84%;

    padding: 10px 14px;

    border-radius: 13px;

    font-size: 13px;

    line-height: 1.5;

}


.fh-message-bot .fh-message-bubble {

    background: #171c22;

    border: 1px solid #242d28;

    color: #f4f6f5;

}


.fh-message-user .fh-message-bubble {

    background: #0f6f3a;

    border: 1px solid #18a957;

    color: #ffffff;

}


.fh-message-name {

    margin-top: 4px;

    padding-left: 4px;

    color: #22c55e;

    font-size: 10px;

}


/* Popular Questions */

.fh-popular-title {

    margin:

        16px
        0
        10px;

    text-align: center;

    color: #83908a;

    font-size: 9px;

    letter-spacing: 2px;

}


.fh-question-list {

    display: flex;

    flex-direction: column;

    align-items: center;

    gap: 7px;

}


.fh-question {

    border: 1px solid #29332d;

    border-radius: 999px;

    background: #171c22;

    color: #22c55e;

    padding: 8px 15px;

    font-size: 11px;

    cursor: pointer;

    transition: .2s ease;

}


.fh-question:hover {

    background: rgba(34,197,94,.10);

    border-color: #22c55e;

    transform: translateY(-1px);

}


/* Footer */

.fh-assistant-footer {

    padding: 10px 10px 12px;

    background: #15191e;

    border-top: 1px solid #26312b;

}


.fh-input-row {

    display: flex;

    align-items: center;

    gap: 7px;

}


.fh-assistant-input {

    flex: 1;

    min-width: 0;

    height: 46px;

    padding: 0 14px;

    border: 2px solid #00d979;

    border-radius: 16px;

    outline: none;

    background: #101418;

    color: #ffffff;

    font-size: 13px;

}


.fh-assistant-input:focus {

    border-color: #22c55e;

    box-shadow:
        0 0 0 2px rgba(34,197,94,.12);

}


.fh-assistant-input::placeholder {

    color: #858d89;

}


.fh-assistant-send {

    width: 48px;
    height: 46px;

    border: none;

    border-radius: 15px;

    background: #0e6d4c;

    color: #061009;

    font-size: 17px;

    cursor: pointer;

    transition: .2s ease;

}


.fh-assistant-send:hover {

    background: #22c55e;

}


.fh-message-team {

    display: block;

    margin-top: 5px;

    padding-left: 2px;

    color: #919994;

    font-size: 9px;

    text-decoration: underline;

}


.fh-message-team:hover {

    color: #22c55e;

}


/* Typing */

.fh-typing {

    display: inline-flex;

    align-items: center;

    gap: 4px;

}


.fh-typing span {

    width: 5px;
    height: 5px;

    border-radius: 50%;

    background: #22c55e;

    animation: fhTyping 1s infinite ease-in-out;

}


.fh-typing span:nth-child(2) {
    animation-delay: .15s;
}


.fh-typing span:nth-child(3) {
    animation-delay: .30s;
}


@keyframes fhTyping {

    0%,
    60%,
    100% {
        transform: translateY(0);
        opacity: .45;
    }

    30% {
        transform: translateY(-3px);
        opacity: 1;
    }

}


/* Mobile */

@media (max-width: 600px) {

    .fh-assistant-window {

        right: 8px;
        bottom: 8px;

        width: calc(100vw - 16px);

        height: min(540px, calc(100vh - 16px));

        border-radius: 16px;

    }


    .fh-assistant-fab {

        right: 16px;
        bottom: 16px;

    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const windowEl =
        document.getElementById(
            'fhAssistantWindow'
        );


    const openButton =
        document.getElementById(
            'fhAssistantOpen'
        );


    const closeButton =
        document.getElementById(
            'fhAssistantClose'
        );


    const input =
        document.getElementById(
            'fhAssistantInput'
        );


    const sendButton =
        document.getElementById(
            'fhAssistantSend'
        );


    const body =
        document.getElementById(
            'fhAssistantBody'
        );


    if (
        !windowEl ||
        !openButton ||
        !closeButton ||
        !input ||
        !sendButton ||
        !body
    ) {
        return;
    }


    /* =====================================================
       OPEN / CLOSE
    ===================================================== */

    openButton.addEventListener(
        'click',
        function () {

            windowEl.classList.add('open');

            openButton.style.display = 'none';

            input.focus();

        }
    );


    closeButton.addEventListener(
        'click',
        function () {

            windowEl.classList.remove('open');

            openButton.style.display = 'flex';

        }
    );


    /* =====================================================
       BOT ANSWERS
    ===================================================== */

    function getBotReply(message)
    {

        const text =
            message
                .toLowerCase()
                .trim();


        if (
            text.includes('delivery') &&
            (
                text.includes('how long') ||
                text.includes('time') ||
                text.includes('take')
            )
        ) {

            return `
                Delivery time may depend on your location,
                order preparation, and driver availability.
                You can check your order status from
                <strong>My Orders</strong>.
            `;

        }


        if (
            text.includes('receive') &&
            text.includes('order')
        ) {

            return `
                Once your order is ready, a FoodieHub driver
                can deliver it to the address you provided
                during checkout. Keep your phone available
                in case the driver needs to contact you.
            `;

        }


        if (
            text.includes('legit') ||
            text.includes('legitimate')
        ) {

            return `
                Yes. FoodieHub is a food ordering management
                system designed to make ordering, delivery,
                and order tracking easier.
            `;

        }


        if (
            text.includes('payment') ||
            text.includes('gcash') ||
            text.includes('cash')
        ) {

            return `
                FoodieHub currently supports
                <strong>Cash on Delivery</strong>
                and <strong>GCash</strong>
                during checkout.
            `;

        }


        if (
            text.includes('promo') ||
            text.includes('discount') ||
            text.includes('coupon')
        ) {

            return `
                Promo codes are not currently available.
                Check FoodieHub announcements for future
                discounts or special offers.
            `;

        }


        if (
            (
                text.includes("didn't receive") ||
                text.includes('did not receive') ||
                text.includes('not receive') ||
                text.includes('where is my order') ||
                text.includes('missing order')
            )
        ) {

            return `
                Please open <strong>My Orders</strong> and
                check the current status of your order.
                If there is still a problem, you can contact
                the FoodieHub support team.
            `;

        }


        if (
            text.includes('cancel')
        ) {

            return `
                Order cancellation depends on the current
                order status. Check your order details or
                contact FoodieHub support for assistance.
            `;

        }


        if (
            text.includes('track') ||
            text.includes('status')
        ) {

            return `
                You can track your order by opening
                <strong>My Orders</strong>. Your order will
                show its current delivery status there.
            `;

        }


        if (
            text.includes('hello') ||
            text.includes('hi') ||
            text.includes('hey')
        ) {

            return `
                Hi! 👋 I'm the FoodieHub Assistant.
                Ask me about delivery, payments, orders,
                or anything else about FoodieHub.
            `;

        }


        return `
            I'm still learning! 🤖
            Try asking about <strong>delivery</strong>,
            <strong>payments</strong>,
            <strong>order tracking</strong>,
            or <strong>cancellations</strong>.
        `;

    }


    /* =====================================================
       ADD MESSAGE
    ===================================================== */

    function addMessage(
        message,
        type
    )
    {

        const wrapper =
            document.createElement('div');


        wrapper.className =
            type === 'user'
                ? 'fh-message fh-message-user'
                : 'fh-message fh-message-bot';


        const bubble =
            document.createElement('div');


        bubble.className =
            'fh-message-bubble';


        bubble.innerHTML =
            message;


        wrapper.appendChild(
            bubble
        );


        if (type === 'bot') {

            const name =
                document.createElement('div');


            name.className =
                'fh-message-name';


            name.textContent =
                'FoodieHub Assistant';


            wrapper.appendChild(
                name
            );

        }


        body.appendChild(
            wrapper
        );


        body.scrollTop =
            body.scrollHeight;

    }


    /* =====================================================
       TYPING INDICATOR
    ===================================================== */

    function showTyping()
    {

        const typing =
            document.createElement('div');


        typing.className =
            'fh-message fh-message-bot';


        typing.id =
            'fhTyping';


        typing.innerHTML = `

            <div class="fh-message-bubble">

                <div class="fh-typing">

                    <span></span>
                    <span></span>
                    <span></span>

                </div>

            </div>

        `;


        body.appendChild(
            typing
        );


        body.scrollTop =
            body.scrollHeight;

    }


    function removeTyping()
    {

        const typing =
            document.getElementById(
                'fhTyping'
            );


        if (typing) {

            typing.remove();

        }

    }


    /* =====================================================
       SEND MESSAGE
    ===================================================== */

    function sendMessage(message)
    {

        message =
            message.trim();


        if (!message) {
            return;
        }


        addMessage(
            escapeHtml(message),
            'user'
        );


        input.value = '';


        showTyping();


        setTimeout(
            function () {

                removeTyping();


                addMessage(
                    getBotReply(message),
                    'bot'
                );

            },
            650
        );

    }


    /* =====================================================
       BUTTON
    ===================================================== */

    sendButton.addEventListener(
        'click',
        function () {

            sendMessage(
                input.value
            );

        }
    );


    /* =====================================================
       ENTER
    ===================================================== */

    input.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Enter'
            ) {

                event.preventDefault();

                sendMessage(
                    input.value
                );

            }

        }
    );


    /* =====================================================
       POPULAR QUESTIONS
    ===================================================== */

    document
        .querySelectorAll(
            '.fh-question'
        )
        .forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        sendMessage(
                            button.dataset.question
                        );

                    }
                );

            }
        );


    /* =====================================================
       ESCAPE HTML
    ===================================================== */

    function escapeHtml(value)
    {

        const div =
            document.createElement('div');


        div.textContent =
            value;


        return div.innerHTML;

    }

});

</script>

