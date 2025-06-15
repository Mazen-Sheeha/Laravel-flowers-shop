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
@section('content')
    <div class="card min-w-full">
        <div class="card-header">
            <h3 class="card-title">
                Orders
            </h3>
            <div class="flex items-center gap-5">
                <div class="menu" data-menu="true">
                    <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-start"
                        data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
                        <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                            <i class="ki-filled ki-dots-vertical">
                            </i>
                        </button>
                        <div class="menu-dropdown menu-default w-full max-w-[175px]" data-menu-dismiss="true">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('adminOrders.index', ['sorting' => 'delivered']) }}">
                                    <span class="menu-title">
                                        Sort By Delivered
                                    </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('adminOrders.index') }}">
                                    <span class="menu-title">
                                        Sort By Pending
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-table scrollable-x-auto">
            <div class="scrollable-auto">
                @if (count($orders) == 0)
                    <h5 class="p-3 text-center">No Orders</h5>
                @else
                    <table class="table align-middle text-2sm text-gray-600">
                        <tr class="bg-gray-100">
                            <th class="text-start font-medium min-w-10">#</th>
                            <th class="text-start font-medium min-w-56">Username</th>
                            <th class="text-start font-medium min-w-56">Shipping Price</th>
                            <th class="text-start font-medium min-w-56">Total</th>
                            <th class="text-start font-medium min-w-56">Status</th>
                            <th class="min-w-16">Actions</th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    {{ $order->id }}
                                </td>
                                <td>
                                    {{ $order->fullname }}
                                </td>
                                <td>
                                    ${{ $order->shipping_cost }}
                                </td>
                                <td>
                                    ${{ $order->total }}
                                </td>
                                <td>
                                    <span
                                        style="padding: 5px 10px; border-radius: 5px; background-color: {{ $order->status === 'delivered' ? 'rgb(2, 214, 2); color:white;' : '#f3f4f6' }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <div class="menu inline-flex" data-menu="true">
                                        <div class="menu-item" data-menu-item-offset="0, 10px"
                                            data-menu-item-placement="bottom-end"
                                            data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                            data-menu-item-trigger="click|lg:click">
                                            <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                                <i class="ki-filled ki-dots-vertical">
                                                </i>
                                            </button>
                                            <div class="menu-dropdown menu-default w-full max-w-[175px]"
                                                data-menu-dismiss="true">
                                                <div class="menu-item">
                                                    <a class="menu-link" href="{{ route('adminOrders.show', $order->id) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-search-list">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            View
                                                        </span>
                                                    </a>
                                                </div>
                                                @if ($order->status === 'pending')
                                                    <form class="menu-item"
                                                        action="{{ route('adminOrders.changeStatus', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="menu-link" href="#">
                                                            <span class="menu-title" style="color:brown; ">
                                                                Deliver
                                                            </span>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
            </div>
            @endif
        </div>
        <div class="card-footer justify-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
