@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Home
@endsection

@section('content')
    {{-- Hero Section Start --}}
    <section class="hero_section">
        <div class="hero_section-content ">
            <h1 class="fade-in">SARI'S FLORAL</h1>
            <p class="fade-in">Natural & Beautiful Flower Here</p>
            <div class="line"></div>
            <p class="fade-in">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                labore.
            </p>
            <a href="{{ route('products.index') }}" class="fade-in">Shop now</a>
        </div>
    </section>
    {{-- Hero Section End --}}

    {{-- Products Section Start --}}

    @if ($products->isNotEmpty())
        <section class="new_arrival_section">
            <div class="heading">
                <h1>New Arrival Items</h1>
            </div>
            <div class="items" style="margin: 30px 0">
                @foreach ($products as $product)
                    <div class="item fade-in">
                        <div>
                            {{ $product->offer() }}
                            <div class="image_container">
                                @php
                                    $image = $product->colors[0]->images->where('product_id', $product->id)->first()
                                        ->image;
                                @endphp
                                <img src="{{ $image }}" alt="Image Not Found">
                            </div>
                            <div class="item_info">
                                <span class="name">{{ $product->name }}</span>
                                <p class="desc">{{ Str::limit($product->desc, 50) }}
                                </p>
                                <div class="price_info">
                                    <span class="price">
                                        ${{ (float) ($product->offer ? ($product->price * (100 - $product->offer)) / 100 : $product->price) }}
                                        @if ($product->offer)
                                            <del
                                                style="font-size: 12px; color: black; font-weight: 400;">{{ (float) $product->price }}</del>
                                        @endif
                                    </span>
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
                    </div>
                @endforeach
            </div>
            <a href="{{ route('products.index') }}"
                style="text-decoration: underline; text-align: center; color:var(--main-pink-color);" class="fade-in">Go
                shopping</a>
        </section>
    @endif
    {{-- Products Section End --}}
@endsection
