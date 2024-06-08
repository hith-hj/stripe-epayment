<x-app-layout>
    <x-slot name="header">
            {{ __('Payment') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-center w-full">
                    <form action="{{ route('payment.purchase', ['id' => $item->id, 'type' => 'product']) }}"
                        method="POST" id="subscribe-form" class="w-1/2 px-2">
                        @csrf
                        <div class="flex flex-row justify-between mb-4 border-b border-gray-300">
                            <div class="">
                                <h4>{{ $item->name }}</h4>
                            </div>
                            <div class="">
                                <label for="plan-silver">
                                    {{ '$ ' . number_format($item->price, 2) }}
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between mb-4">
                            <label for="card-holder-name">
                                Card Holder Name
                            </label>
                            <input id="card-holder-name" type="text" value="{{ auth()->user()->name }}" disabled
                                class="border-none text-right p-0">
                        </div>
                        <div class="form-row mb-4">
                            <label for="card-element">Card Information</label>
                            <div id="card-element" class="mt-4"></div>
                            <div id="card-errors" role="alert" class="text-red-500"></div>
                        </div>
                        <div class="stripe-errors text-red-500"></div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group text-center">
                            <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}"
                                class="bg-green-500 hover:bg-green-700 rounded-md px-5 w-full disabled:bg-gray-300 mb-4">
                                SUBMIT
                            </button>
                            <span class="text-gray-400" id="process_payment"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {
        hidePostalCode: true,
        style: style
    });
    card.mount('#card-element');
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const status = document.getElementById('process_payment');
    const clientSecret = cardButton.dataset.secret;
    cardButton.addEventListener('click', async (e) => {
        cardButton.disabled = true;
        status.textContent = 'Processing...';

        const {
            setupIntent,
            error
        } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        );
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            cardButton.disabled = false;
            status.textContent = 'Error';
        } else {
            paymentMethodHandler(setupIntent.payment_method);
            status.textContent = 'Done';
        }
    });

    function paymentMethodHandler(payment_method) {
        var form = document.getElementById('subscribe-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>
