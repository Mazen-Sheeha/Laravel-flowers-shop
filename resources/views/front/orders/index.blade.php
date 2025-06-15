@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Orders
@endsection
@section('content')
    @if (count($orders) > 0)
        <section class="orders_section">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Craated At</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td data-label="Created_at">{{ $order->created_at->format('d-m-Y') }}</td>
                            <td data-label="Total">${{ number_format($order->total, 2) }}</td>
                            <td>
                                <span
                                    style="padding: 5px 10px; border-radius: 5px; background-color: {{ $order->status === 'delivered' ? 'rgb(100, 214, 2); color:white;' : '#f3f4f6' }}">{{ $order->status }}</span>
                            </td>
                            <td data-label="Show">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    style="color: var(--main-pink-color); text-decoration: underline;">Click
                                    to show order</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @else
        <div class="empty_content">
            No Orders
        </div>
    @endif
@endsection
