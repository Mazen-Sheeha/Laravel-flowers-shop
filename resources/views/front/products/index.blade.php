@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Products
@endsection
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section('content')
    <section class="products">
        @if ($productsCount)
            <div class="heading">
                <h1>Our Floral Products</h1>
            </div>
            <div class="filter_products_container">
                <form class="filter">
                    <div>
                        <label>Search by name</label>
                        <input type="text" name="name" placeholder="Serach by name..." class="form_control"
                            value="{{ request()->name }}">
                    </div>
                    <div>
                        <label>Select Category</label>
                        <select name="category_id">
                            <option value="all">All Categories</option>
                            @foreach ($categories as $cat)
                                <option @selected(request()->category_id == $cat->id) value="{{ $cat->id }}">{{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($colors->count() > 1)
                        <div class="color-picker" id="colorPicker">
                            <label>Select colors</label>
                            @foreach ($colors as $color)
                                <label class="color-option" style="background-color: {{ $color->color }};"
                                    data-id="{{ $color->id }}">
                                    <input type="checkbox" @checked(request()->color_ids && in_array($color->id, request()->color_ids)) name="color_ids[]"
                                        value="{{ $color->id }}" hidden>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    <div>
                        <label>Sort by</label>
                        <select name="sorting" class="sorting_select">
                            <option @selected(request()->sorting === 'latest') value="latest">Latest</option>
                            <option @selected(request()->sorting === 'price_up') value="price_up">Price : High to Low</option>
                            <option @selected(request()->sorting === 'price_down') value="price_down">Price : Low to High</option>
                        </select>
                    </div>
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i>
                        Apply Filters
                    </button>
                    @if (request()->has('sorting'))
                        <a class="filter-btn" href="{{ route('products.index') }}"
                            style="text-align: center;background-color: transparent; color:black; text-decoration: underline">
                            Clear Filters
                        </a>
                    @endif
                </form>
                <div class="items">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', ['product' => $product->id,'color_id' =>is_array(request()->color_ids) &&$product->colors->where('color_id', request()->color_ids[0])->where('product_id', $product->id)->first()? $product->colors->where('color_id', request()->color_ids[0])->where('product_id', $product->id)->first()->id: $product->colors->first()->id]) }}"
                            class="item fade-in">
                            <div>
                                {{ $product->offer() }}
                                <div class="image_container">
                                    @php
                                        if (
                                            is_array(request()->color_ids) &&
                                            $product->colors
                                                ->where('color_id', request()->color_ids[0])
                                                ->where('product_id', $product->id)
                                                ->first()
                                        ) {
                                            $image = $product->colors
                                                ->where('color_id', request()->color_ids[0])
                                                ->where('product_id', $product->id)
                                                ->first()
                                                ->images->where('product_id', $product->id)
                                                ->first()->image;
                                        } else {
                                            $image = $product->colors
                                                ->first()
                                                ->images->where('product_id', $product->id)
                                                ->first()->image;
                                        }
                                    @endphp
                                    <img src="{{ $image }}" alt="Image Not Found">
                                </div>
                                <div class="item_info">
                                    <span class="name">{{ $product->name }}</span>
                                    <p class="desc">{{ Str::limit($product->desc, 50) }}
                                    </p>
                                    <div class="price_info">
                                        <span class="price">
                                            ${{ $product->current_price }}
                                            @if ($product->offer)
                                                <del
                                                    style="font-size: 12px; color: black; font-weight: 400;">${{ (float) $product->price }}</del>
                                            @endif
                                        </span>
                                        <form action="{{ route('cart.store') }}" class="add-to-cart-form" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="color_id"
                                                value="{{ is_array(request()->color_ids) &&$product->colors->where('color_id', request()->color_ids[0])->where('product_id', $product->id)->first()? $product->colors->where('color_id', request()->color_ids[0])->where('product_id', $product->id)->first()->id: $product->colors->first()->id }}">
                                            <button>
                                                <i class="fal fa-shopping-cart add_to_cart_btn"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @if (count($product->colors) > 1)
                                    <div style="display: flex; gap:5px;">
                                        @foreach ($product->colors as $color)
                                            <div
                                                style="border: 1px solid rgb(168, 167, 167);width: 20px; height: 20px;border-radius: 50%; background-color: {{ $color->color }};">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                    <div class="links">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        @else
            <div style="height: 40dvh;display: flex; align-items:center; justify-content:center; width:100%;">
                <h1>No Products</h1>
            </div>
        @endif
    </section>
@endsection
@section('script')
    <script>
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', () => {
                const input = option.querySelector('input');
                input.checked = !input.checked;
                option.classList.toggle('selected');
            });
        });
        document.querySelectorAll('form.add-to-cart-form').forEach(form => {
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                takeAction(form, "POST");
            });
        });


        function takeAction(form, method) {
            const url = form.action;
            const token = form.querySelector("[name='_token']").value;
            const product_id = form.querySelector("[name='product_id']").value;
            const color_id = form.querySelector("[name='color_id']").value;

            fetch(url, {
                    method,
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        product_id,
                        color_id,
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data['success']) {
                        if (data['ac'] === 'store') {
                            const cartCount = document.getElementById("cart_count");
                            if (cartCount.classList.contains('none')) {
                                cartCount.classList.remove('none');
                            }
                            cartCount.innerHTML = parseInt(cartCount.innerHTML || 0) + 1;
                        }
                        toastify().success(data['message']);
                    } else {
                        if (data['message'] == "Unauthenticated.") {
                            location.href = "{{ route('login') }}";
                        } else {
                            toastify().error('Something went wrong');
                        }
                    }
                })
        }
    </script>
@endsection
