@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Cart
@endsection
@section('content')
    @if (count($cartItems) > 0)
        <section class="orders_section">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td data-label="Image">
                                @php
                                    $image = $item->color->images->where('product_id', $item->product_id)->first()
                                        ->image;
                                @endphp
                                <img src="{{ $image }}" width="75" height="75" alt="Image Not Found"
                                    style="object-fit: cover">
                            </td>
                            <td data-label="Color">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span
                                        style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: {{ $item->color->color }}; border: 1px solid #ccc;"></span>
                                </div>
                            </td>
                            <td data-label="Name">
                                {{ $item->product->name }}
                            </td>
                            <td data-label="Price">
                                ${{ number_format($item->product->current_price, 2) }}
                            </td>
                            <td data-label="Quantity">
                                <form action="{{ route('cart.update') }}" method="POST" class="updateCart cart-form"
                                    colorId="{{ $item->color_id }}" productId="{{ $item->product_id }}"
                                    productPrice={{ $item->product->current_price }}>
                                    @csrf
                                    <input type="number" class="updateCartInput"
                                        style="padding: 10px 20px; width: 100px;border: 1px solid rgba(128, 128, 128, 0.507); border-radius: 10px"
                                        min="1" value="{{ $item->quantity }}">
                                </form>
                            </td>
                            <td data-label="Total" class="total">
                                ${{ number_format((float) $item->product->current_price * $item->quantity, 2) }}
                            </td>
                            <td data-label="Delete">
                                <form action="{{ route('cart.destroy') }}" colorId="{{ $item->color_id }}"
                                    productId="{{ $item->product_id }}" class="deleteCartItemForm cart-form">
                                    @csrf
                                    <button
                                        style="font-size: 25px;  cursor: pointer; background-color: transparent">&times;</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-summary"
                style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 10px; max-width: 500px; margin-left: auto;">
                <h3 style="margin-bottom: 20px; font-family: 'Montserrat', sans-serif; color: #4a4a4a;">Cart Summary</h3>
                @foreach ($cartItems as $item)
                    <div class="order-item" id="cart-product-{{ $item->product_id }}-color-{{ $item->color_id }}">
                        <div class="item-info">
                            <div class="item-name">{{ $item->product->name }}</div>
                            <div class="item-attributes">
                                @if ($item->color_id ?? false)
                                    <div
                                        style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $item->color->color }};">
                                    </div>
                                @endif
                            </div>
                            <div class="item-quantity">Qty: <span
                                    id="quantity-product-{{ $item->product_id }}-color-{{ $item->color_id }}">
                                    {{ $item->quantity }}</span></div>
                        </div>
                        <div class="item-price">
                            $<span id="price-product-{{ $item->product_id }}-color-{{ $item->color_id }}"
                                price="{{ $item->product->current_price }}">{{ number_format($item->product->current_price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                @endforeach
                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 25px; font-weight: bold; font-size: 18px;">
                    <span>Subtotal:</span>
                    <span class="subtotal">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px">
                    <a href="{{ route('orders.create') }}"
                        style="display: block; width: 100%; padding: 12px; background-color: var(--main-pink-color); color: white; text-align: center; border-radius: 5px; font-weight: bold; transition: all 0.3s ease;">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('products.index') }}"
                        style="text-decoration: underline;color: var(--main-pink-color);">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </section>
    @else
        <div class="empty_content" style="flex-direction: column">
            <p>Your cart is empty</p>
            <a href="{{ route('products.index') }}"
                style="padding: 10px 20px; text-decoration: underline;color: var(--main-pink-color);">
                Continue Shopping
            </a>
        </div>
    @endif
@endsection
@section('script')
    <script>
        document.querySelectorAll(".cart-form").forEach(form => form.addEventListener("submit", (e) => e.preventDefault()));
        const updateCartInputs = Array.from(document.getElementsByClassName('updateCartInput'));
        updateCartInputs.forEach((input) => {
            input.addEventListener('change', function(e) {
                if (+e.target.value > 100) e.target.value = 1;
                const form = e.target.closest("form");
                const quantity = +input.value;
                const priceCell = form.closest("tr").querySelector("td[data-label='Price']");
                const productPrice = parseFloat(priceCell.textContent.replace('$', ''));
                const totalElement = form.closest("tr").querySelector(".total");
                takeAction(form, "PUT", input.value);
                totalElement.textContent = '$' + parseFloat((quantity * productPrice).toFixed(2));
                const productId = form.getAttribute("productId");
                const colorId = form.getAttribute("colorId");
                updateCartSummary("PUT", productId, colorId, input.value);
            });
        });

        const deleteCartItemForms = Array.from(document.getElementsByClassName('deleteCartItemForm'));
        deleteCartItemForms.forEach((form) => {
            form.addEventListener('submit', function(e) {
                takeAction(form, "DELETE");
                const trsLength = Array.from(form.closest("table").querySelectorAll('tr')).length;
                if (trsLength === 2) {
                    form.closest("table").remove();
                    document.querySelector("#cart_count").remove();
                    document.querySelector(".cart-summary").remove();
                } else {
                    form.closest("tr").remove();
                    const cartCount = document.querySelector("#cart_count")
                    cartCount.innerHTML = +cartCount.innerHTML - 1;
                }
                const productId = form.getAttribute("productId");
                const colorId = form.getAttribute("colorId");
                updateCartSummary("DELETE", productId, colorId);
            });
        });

        function takeAction(form, method, quantity = null) {
            const url = form.action;
            const token = form.querySelector("[name='_token']").value;
            const product_id = form.getAttribute("productId");
            const color_id = form.getAttribute("colorId");
            fetch(url, {
                    method,
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify(quantity ? {
                        product_id,
                        color_id,
                        quantity
                    } : {
                        product_id,
                        color_id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data['success']) {
                        toastify().success(data['message']);
                    } else {
                        toastify().error('Something wrong');
                    }
                })
        }

        function updateCartSummary(method, productId, colorId, quantity = null) {
            let subtotal = 0;
            if (method === "DELETE") {
                document.querySelector("#cart-product-" + productId + "-color-" + colorId).remove();
            }
            document.querySelectorAll('.total').forEach(totalElement => {
                subtotal += parseFloat(totalElement.textContent.replace('$', ''));
            });

            document.querySelector('.subtotal').textContent = '$' + subtotal.toFixed(2);
            if (method === 'PUT') {
                document.querySelector("#quantity-product-" + productId + "-color-" + colorId).innerHTML = quantity;
                const cartItemPrice = document.querySelector("#price-product-" + productId + '-color-' + colorId);
                cartItemPrice.innerHTML = (quantity * cartItemPrice.getAttribute("price")).toFixed(2);
            }
        }
    </script>
@endsection
