@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Products
    </span>
    @if (request()->search)
        <i class="ki-filled ki-right text-gray-500 text-3xs">
        </i>
        <span class="text-gray-700">
            Search
        </span>
    @elseif(request()->category_id)
        <i class="ki-filled ki-right text-gray-500 text-3xs">
        </i>
        <span class="text-gray-700">
            "{{ $category }}" Category Products
        </span>
    @endif
@endsection
@section('content')

    <div class="card-table scrollable-x-auto">
        <form action="{{ route('adminProducts.index') }}" method="GET" class="flex gap-3" id="searchForm">
            <input type="text" class="input" name="search" id="searchInput" placeholder="Search products by name..."
                value="{{ request()->search }}">

            <button type="submit" id="searchBtn" class="btn btn-primary flex justify-center max-w-56">Search</button>
            <a href="{{ route('adminProducts.index') }}" id="resetLink"
                class="btn btn-secondary flex justify-center max-w-56">Reset</a>
        </form>


    </div>
    <div class="card min-w-full">
        <div class="card-header">
            <h3 class="card-title">
                {{ request()->category_id ? "Products in \"$category\" Category" : (request()->search ? 'Search Results' : 'Products') }}
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
                                <a class="menu-link" href="{{ route('adminProducts.create') }}">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-add-files">
                                        </i>
                                    </span>
                                    <span class="menu-title">
                                        Add
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
                @if ($products->count() === 0)
                    @if (request()->search)
                        <h5 class="p-3 text-center">No Search Results</h5>
                    @else
                        <h5 class="p-3 text-center">No Products</h5>
                    @endif
                @else
                    <table class="table align-middle text-2sm text-gray-600">
                        <tr class="bg-gray-100">
                            <th class="text-start font-medium min-w-10">#</th>
                            <th class="text-start font-medium min-w-56">Image</th>
                            <th class="text-start font-medium min-w-56">Name</th>
                            <th class="text-start font-medium min-w-56">Current Price</th>
                            <th class="text-start font-medium min-w-56">Offer</th>
                            <th class="min-w-16">Actions</th>
                        </tr>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    {{ $product->id }}
                                </td>
                                <td>
                                    @php
                                        $image = $product->colors
                                            ->first()
                                            ->images->where('product_id', $product->id)
                                            ->first()->image;
                                    @endphp
                                    <img src="{{ $image }}" width="100" alt="Image Not Found" class="rounded"
                                        style="object-fit: cover; height: 75px">
                                </td>
                                <td>
                                    {{ $product->name }}
                                </td>
                                <td>
                                    ${{ $product->current_price }}
                                </td>
                                <td>
                                    {{ $product->offer ? "$product->offer%" : '______' }}
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
                                                    <a class="menu-link"
                                                        href="{{ route('adminProducts.show', ['adminProduct' => $product->id, 'color_id' => $product->colors->first()->id]) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-search-list">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            View
                                                        </span>
                                                    </a>
                                                </div>
                                                @if (!$product->orders->count() > 0)
                                                    <div class="menu-separator">
                                                    </div>
                                                @endif
                                                <div class="menu-item">
                                                    <a class="menu-link"
                                                        href="{{ route('adminProducts.edit', $product->id) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-pencil">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            Edit
                                                        </span>
                                                    </a>
                                                </div>
                                                @if (!$product->orders->count())
                                                    <form class="menu-item"
                                                        action="{{ route('adminProducts.destroy', $product->id) }}"
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
            {{ $products->links() }}
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const searchBtn = document.getElementById("searchBtn");
            const resetLink = document.getElementById("resetLink");
            const originalSearch = @json(request()->search);

            function updateButton() {
                if (searchInput.value.trim() === originalSearch?.trim()) {
                    searchBtn.classList.add('hidden');
                    resetLink.classList.remove('hidden');
                } else {
                    searchBtn.classList.remove('hidden');
                    resetLink.classList.add('hidden');
                }
            }
            searchInput.addEventListener("input", updateButton);
            updateButton();
        });
    </script>
@endsection
