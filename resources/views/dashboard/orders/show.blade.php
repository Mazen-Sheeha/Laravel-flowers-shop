@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Orders
    </span>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        header {
            width: initial;
            padding: 0;
        }

        .dropdown-content {
            padding: 10px;
        }

        .app-table thead th {
            background: #f9f9f9 !important;
            color: #78829d !important;
            font-weight: 500;
            font-size: 0.8125rem;
        }
    </style>
@endsection
@section('content')
    <section class="orders_section" style="width: 100%">
        <table class="app-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Color</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    @php
                        $product = $item->product;
                        $color = $item->color;
                        $image = $color
                            ? $color->images->where('product_id', $product->id)->first()->image
                            : $product->colors->first()->images->where('product_id', $product->id)->first()->image;
                    @endphp
                    <tr>
                        <td data-label="Image">
                            <img src="{{ asset($image) }}" width="75" height="75" alt="Image Not Found"
                                style="object-fit: cover; border-radius: 8px; height: 75px">
                        </td>
                        @if ($color)
                            <td data-label="Color">
                                <span
                                    style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: {{ $color->color }}; border: 1px solid #ccc;"></span>
                            </td>
                        @endif
                        <td data-label="Name">{{ $product->name }}</td>
                        <td data-label="Quantity">
                            {{ $item->quantity }}
                        </td>
                        <td data-label="Total" class="total">
                            ${{ number_format($item->quantity * $item->price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-summary"
            style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 10px; max-width: 500px; margin-left: auto;">
            <h3 style="margin-bottom: 20px; font-family: 'Montserrat', sans-serif; color: #4a4a4a;">Order Summary</h3>
            @foreach ($order->items as $item)
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
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="font-weight: 500;">Subtotal:</span>
                <span
                    class="subtotal">${{ number_format($order->items->sum(fn($i) => $i->product->current_price * $i->quantity), 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="font-weight: 500;">Shipping:</span>
                <span class="subtotal">${{ $order->shipping_cost }}</span>
            </div>
            <div
                style="display: flex; justify-content: space-between; margin-bottom: 25px; font-weight: bold; font-size: 18px;">
                <span>Total:</span>
                <span class="grand-total">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </section>
@endsection
