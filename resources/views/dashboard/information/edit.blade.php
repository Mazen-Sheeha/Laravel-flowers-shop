@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        ZIP Code & It's Shipping Price
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Edit
    </span>
@endsection
@section('content')
    <div class="card bg-white shadow-sm rounded-lg border border-gray-200 flex">
        <div class="card-body p-6">
            <form action="{{ route('zip_code.update', $zip_code->id) }}" method="post" enctype="multipart/form-data"
                class="flex flex-col md:flex-row items-center gap-6">
                @csrf
                @method('PUT')
                <div class="flex items-center">
                    <h5 class="text-gray-800 font-semibold">Update ZIP code & it's shipping price</h5>
                </div>
                <div class="flex items-center relative">
                    <input type="text" class="input" name="zip_code" placeholder="ZIP Code"
                        value="{{ old('zip_code') ? old('zip_code') : $zip_code->zip_code }}">
                </div>
                <div class="flex items-center relative">
                    $<input type="number" min="1" max="1000" placeholder="5" class="input"
                        placeholder="Shipping Price" name="shipping_price" style="width: 65px"
                        value="{{ old('shipping_price') ? old('shipping_price') : $zip_code->shipping_price }}">
                </div>
                <button type="submit"
                    class="btn btn-light hover:bg-blue-600 text-white px-4 py-2 rounded-md md:ml-auto transition-colors duration-200">
                    <i class="ki-filled ki-pencil"></i> Update ZIP Code
                </button>
            </form>
        </div>
    </div>
@endsection
