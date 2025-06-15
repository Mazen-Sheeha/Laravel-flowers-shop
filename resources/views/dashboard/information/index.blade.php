@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Information
    </span>
@endsection
@section('content')

    <form class="card-body grid gap-5" method="POST" action="{{ route('information.update') }}">
        @csrf
        @method('PUT')
        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
            <label class="form-label max-w-56">
                Phone
            </label>
            <input class="input" placeholder="Phone" type="text" name="phone"
                value="{{ old('phone') ? old('phone') : $information->phone }}" />
        </div>
        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
            <label class="form-label max-w-56">
                Email
            </label>
            <input class="input" placeholder="Email" type="text" name="email"
                value="{{ old('email') ? old('email') : $information->email }}" />
        </div>
        <button class="btn btn-primary flex justify-center">
            Update
        </button>
    </form>
    <div class="card bg-white shadow-sm rounded-lg border border-gray-200 flex">
        <div class="card-body p-6">
            <form action="{{ route('zip_code.store') }}" method="post" enctype="multipart/form-data"
                class="flex flex-col md:flex-row items-center gap-6">
                @csrf
                <div class="flex items-center">
                    <h5 class="text-gray-800 font-semibold">Add ZIP code</h5>
                </div>
                <div class="flex items-center relative">
                    <input type="text" class="input" name="zip_code" placeholder="ZIP Code"
                        value="{{ old('zip_code') }}">
                </div>
                <div class="flex items-center relative">
                    Shipping Price $<input type="number" min="1" max="1000" placeholder="5" class="input"
                        placeholder="Shipping Price" name="shipping_price" style="width: 65px"
                        value="{{ old('shipping_price') }}">
                </div>
                <button type="submit"
                    class="btn btn-light hover:bg-blue-600 text-white px-4 py-2 rounded-md md:ml-auto transition-colors duration-200">
                    <i class="fas fa-plus me-2"></i> Add ZIP code
                </button>
            </form>
        </div>
    </div>
    <div class="card min-w-full mt-7">
        <div class="card-header">
            <h3 class="card-title">
                ZIP codes & their shipping prices
            </h3>
        </div>
        <div class="card-table scrollable-x-auto">
            @if (count($zip_codes) === 0)
                <h3 class="text-center p-4">No ZIP Codes</h3>
            @else
                <div class="scrollable-auto">
                    <table class="table align-middle text-2sm text-gray-600">
                        <tr class="bg-gray-100">
                            <th class="text-start font-medium min-w-15">ZIP Code</th>
                            <th class="min-w-16">Shipping Price</th>
                            <th class="min-w-16">Actions</th>
                        </tr>
                        @foreach ($zip_codes as $code)
                            <tr>
                                <td>
                                    {{ $code->zip_code }}
                                </td>
                                <td>
                                    ${{ $code->shipping_price }}
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
                                                    <a class="menu-link" href="{{ route('zip_code.edit', $code->id) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-pencil">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            Edit
                                                        </span>
                                                    </a>
                                                </div>
                                                <form class="menu-item" action="{{ route('zip_code.destroy', $code->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="menu-link" href="#">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-trash">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            Remove
                                                        </span>
                                                    </button>
                                                </form>
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
            {{ $zip_codes->links() }}
        </div>
    </div>
@endsection
