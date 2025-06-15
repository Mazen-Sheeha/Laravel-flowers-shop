@extends('front.layouts.app')

@section('title')
    SARI'S FLORAL | Cart
@endsection

@section('content')
    <section class="orders_section">
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
                                style="object-fit: cover; border-radius: 8px;">
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
