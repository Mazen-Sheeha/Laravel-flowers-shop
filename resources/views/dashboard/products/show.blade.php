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
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        {{ $product->name }}
    </span>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        header {
            width: initial;
            padding: 0;
            display: flex
        }

        .dropdown-content {
            padding: 10px;
        }
    </style>
@endsection
@section('content')
    <section class="product-section">
        <div class="product-container">
            <div class="product-gallery">
                <div class="main-image-slider">
                    <div class="slider-container">
                        <div class="slider-track">
                            @php
                                $images = request()->color_id
                                    ? $product->colors
                                        ->where('id', request()->color_id)
                                        ->first()
                                        ->images->where('product_id', $product->id)
                                    : $product->colors->first()->images->where('product_id', $product->id);
                            @endphp
                            @foreach ($images as $image)
                                <div class="slide">
                                    <img src="{{ asset($image->image) }}" alt="Product Image" loading="lazy">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button class="slider-nav prev">&#10094;</button>
                    <button class="slider-nav next">&#10095;</button>
                </div>
                <div class="thumbnail-container">
                    @foreach ($images as $image)
                        <div class="thumbnail active">
                            <img src="{{ asset($image->image) }}" alt="Product Image" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-price">
                    <span class="current-price">${{ $product->current_price }}</span>
                    @if ($product->offer)
                        <span class="original-price">${{ $product->price }}</span>
                        <span class="discount">({{ $product->offer }}% off)</span>
                    @endif
                </div>

                <div class="product-description">
                    <p>{{ $product->desc }}</p>
                </div>
                @if (count($product->colors) > 1)
                    <div class="color-variants">
                        <h3>Available Colors:</h3>
                        <div class="color-options">
                            @foreach ($product->colors as $color)
                                <a href="{{ route('adminProducts.show', ['adminProduct' => $product->id, 'color_id' => $color->id]) }}"class="color-option"
                                    style="background-color: {{ $color->color }};" title="Red Roses"></a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.querySelector('.slider-track');
            const slides = document.querySelectorAll('.slide');
            const thumbnails = document.querySelectorAll('.thumbnail');
            const prevBtn = document.querySelector('.slider-nav.prev');
            const nextBtn = document.querySelector('.slider-nav.next');
            let currentIndex = 0;
            const slideCount = slides.length;

            function updateSlider() {
                track.style.transform = `translateX(-${currentIndex * 100}%)`;

                thumbnails.forEach((thumb, index) => {
                    thumb.classList.toggle('active', index === currentIndex);
                });
            }

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    currentIndex = index;
                    updateSlider();
                });
            });

            nextBtn?.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slideCount;
                updateSlider();
            });

            prevBtn?.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                updateSlider();
            });

            const minusBtn = document.querySelector('.quantity-btn.minus');
            const plusBtn = document.querySelector('.quantity-btn.plus');
            const quantityInput = document.querySelector('.quantity-input');

            minusBtn?.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });

            plusBtn?.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                quantityInput.value = value + 1;
            });
        });
    </script>
@endsection
