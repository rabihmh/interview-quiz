<x-front-layout title="Order Payment">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div id="payment-message" style="display: none;" class="alert alert-info"></div>
                    <form action="" method="post" id="payment-form">
                        <div id="payment-element"></div>
                        <button type="submit" id="submit" class="btn btn-primary">
                            <span id="button-text">Pay now</span>
                            <span id="spinner" style="display: none;">Processing...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // This is your test publishable API key.
        const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");
        let elements;
        initialize();
        document
            .querySelector("#payment-form")
            .addEventListener("submit", handleSubmit);
        // Fetches a payment intent and captures the client secret
        async function initialize() {
            const {
                clientSecret
            } = await fetch("{{ route('front.stripe.paymentIntent.create', $order->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}"
                }),
            }).then((r) => r.json());
            elements = stripe.elements({
                clientSecret
            });
            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");
        }
        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);
            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ route('front.stripe.return', $order->id) }}",
                },
            });

            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }
            setLoading(false);
        }


        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");
            messageContainer.style.display = "block";
            messageContainer.textContent = messageText;
            setTimeout(function() {
                messageContainer.style.display = "none";
                messageText.textContent = "";
            }, 4000);
        }

        function setLoading(isLoading) {
            if (isLoading) {

                document.querySelector("#submit").disabled = true;
                document.querySelector("#spinner").style.display = "inline";
                document.querySelector("#button-text").style.display = "none";
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#spinner").style.display = "none";
                document.querySelector("#button-text").style.display = "inline";
            }
        }
    </script>
</x-front-layout>
