@extends('front.layouts.app')

@section('title', "SARI'S FLORAL | Checkout")

@section('content')
    <section class="checkout-section">
        <div class="checkout-container">
            <h1 class="checkout-title">Checkout</h1>

            <div class="checkout-content">
                <!-- Checkout Form -->
                <div class="checkout-form">
                    <h2 class="form-title">Shipping Information</h2>
                    <form id="payment-form" action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="fullname">Full Name *</label>
                            <input type="text" id="fullname" name="fullname" required
                                value="{{ old('fullname', Auth::user()->name ?? '') }}"
                                class="@error('fullname') is-invalid @enderror">
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required
                                    value="{{ old('email', Auth::user()->email ?? '') }}"
                                    class="@error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone *</label>
                                <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}"
                                    class="@error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address *</label>
                            <input type="text" id="address" name="address" required value="{{ old('address') }}"
                                class="@error('address') is-invalid @enderror">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="zip_code">ZIP Code *</label>
                                <select name="zip_code" id="zip_code" required
                                    class="@error('zip_code') is-invalid @enderror">
                                    <option value="" disabled selected>Select ZIP Code</option>
                                    @foreach ($zip_codes as $code)
                                        <option value="{{ $code->zip_code }}" data-shipping="{{ $code->shipping_price }}"
                                            {{ old('zip_code') == $code->zip_code ? 'selected' : '' }}>
                                            {{ $code->zip_code }} (Shipping:
                                            ${{ number_format($code->shipping_price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Stripe Payment Section -->
                        <div class="payment-section">
                            <div class="form-group">
                                <label for="card-element">Credit or Debit Card *</label>
                                <div id="card-element" class="form-control">
                                    <!-- Stripe Card Element will be inserted here -->
                                </div>
                                <div id="card-errors" role="alert" class="text-danger"></div>
                            </div>
                        </div>

                        <input type="hidden" name="payment_method" id="payment-method">
                        <input type="hidden" name="shipping_cost" id="shipping-cost-input"
                            value="{{ $shippingCost ?? 0 }}">
                        <input type="hidden" name="total" id="total-amount-input" value="{{ $total ?? 0 }}">

                        <button type="submit" class="place-order-btn" id="submit-button">
                            <span id="button-text">Place Order</span>
                            <div id="spinner" class="spinner hidden"></div>
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>

                    <div class="order-items">
                        @if (isset($cartItems) && count($cartItems) > 0)
                            @foreach ($cartItems as $item)
                                @php
                                    $image =
                                        $item->color->images->where('product_id', $item->product_id)->first()->image ??
                                        'images/default.png';
                                @endphp
                                <div class="order-item">
                                    <div class="item-image">
                                        <img src="{{ asset($image) }}" alt="Product Image"
                                            style="width: 50px; height:50px; object-fit: cover">
                                    </div>
                                    <div class="item-info">
                                        <div class="item-name">{{ $item->product->name }}</div>
                                        <div class="item-attributes">
                                            @if ($item->color_id ?? false)
                                                <div
                                                    style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $item->color->color }};">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="item-quantity">Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="item-price">
                                        ${{ number_format($item->product->current_price * $item->quantity, 2) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <p>Your cart is empty</p>
                            </div>
                        @endif
                    </div>

                    <div class="summary-totals">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal">${{ number_format($subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span id="shipping-cost-display">
                                @if (isset($shippingCost) && $shippingCost)
                                    ${{ number_format($shippingCost, 2) }}
                                @else
                                    Select ZIP Code
                                @endif
                            </span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total">${{ number_format(($subtotal ?? 0) + ($shippingCost ?? 0), 2) }}</span>
                        </div>
                    </div>

                    <div class="delivery-info">
                        <h3>Substitution Policy</h3>
                        <p>•    Due to seasonal availability, we may substitute flowers or containers while maintaining the
                            arrangement's overall style and value.</p>
                        <p>•    We will make every effort to contact you prior to substitution.</p>
                        <p> •    Due to seasonal availability, we may substitute flowers or containers while maintaining the
                            arrangement's overall style and value.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
    <style>
        .spinner {
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 2px solid #fff;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin-left: 10px;
            display: inline-block;
            vertical-align: middle;
        }

        .hidden {
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .invalid-feedback {
            color: #dc3545 !important;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .order-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .item-image {
            width: 80px;
            margin-right: 15px;
        }

        .item-image img {
            width: 100%;
            border-radius: 5px;
        }

        .item-info {
            flex-grow: 1;
        }

        .empty-cart {
            text-align: center;
            padding: 20px;
        }

        .empty-cart i {
            font-size: 40px;
            color: #ccc;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const elements = stripe.elements();

            const style = {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a',
                },
            };

            const cardElement = elements.create('card', {
                style
            });
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('spinner');
            const cardErrors = document.getElementById('card-errors');

            // Handle card input errors
            cardElement.on('change', function(event) {
                cardErrors.textContent = event.error ? event.error.message : '';
            });

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                submitButton.disabled = true;
                buttonText.textContent = 'Processing...';
                spinner.classList.remove('hidden');

                const billingDetails = {
                    name: document.getElementById('fullname').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    address: {
                        line1: document.getElementById('address').value,
                        postal_code: document.getElementById('zip_code').value,
                    },
                };

                const {
                    paymentMethod,
                    error
                } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                    billing_details: billingDetails,
                });

                if (error) {
                    cardErrors.textContent = error.message;
                    submitButton.disabled = false;
                    buttonText.textContent = 'Place Order';
                    spinner.classList.add('hidden');
                } else {
                    document.getElementById('payment-method').value = paymentMethod.id;
                    form.submit();
                }
            });

            // Update shipping and total when zip code changes
            const zipCodeSelect = document.getElementById('zip_code');
            zipCodeSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const shippingCost = parseFloat(selectedOption.dataset.shipping || 0);
                const subtotal = parseFloat({{ $subtotal ?? 0 }});
                const total = (subtotal + shippingCost).toFixed(2);

                document.getElementById('shipping-cost-display').textContent = '$' + shippingCost.toFixed(
                    2);
                document.getElementById('total').textContent = '$' + total;
                document.getElementById('shipping-cost-input').value = shippingCost;
                document.getElementById('total-amount-input').value = total;
            });
        });
    </script>

@endsection
