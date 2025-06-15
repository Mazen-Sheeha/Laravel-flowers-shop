@extends('front.layouts.app')

@section('title', 'Product Name - Saris Floral')

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
                                    <img src="{{ asset($image->image) }}" alt="Product Image">
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
                            <img src="{{ asset($image->image) }}" alt="Product Image" style="min-width: 250px">
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

                @if ($product->colors->count() > 1)
                    <!-- Color Variants -->
                    <div class="color-variants">
                        <h3>Available Colors:</h3>
                        <div class="color-options">
                            @foreach ($product->colors as $color)
                                <a href="{{ route('products.show', ['product' => $product->id, 'color_id' => $color->id]) }}"class="color-option"
                                    style="background-color: {{ $color->color }};" title="Red Roses"></a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Add to Cart -->
                <form class="add-to-cart" method="POST"
                    action="{{ $cartItem ? route('cart.update') : route('cart.store') }}"
                    style="display: flex; flex-wrap: wrap">
                    @csrf
                    <input type="hidden" name="color_id" value="{{ request()->color_id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="quantity-selector" style="max-height: 35px ;max-width: fit-content">
                        <div class="quantity-btn minus" style="display: flex; align-items: center; justify-content: center">
                            -</div>
                        <input type="number" value="{{ $cartItem ? $cartItem->quantity : (int) 1 }}" min="1"
                            class="quantity-input" name="quantity">
                        <div class="quantity-btn plus" style="display: flex; align-items: center; justify-content: center;">
                            +
                        </div>
                    </div>
                    <button class="add-to-cart-btn" style="overflow-wrap: break-word;">Add to Cart</button>
                </form>
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

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slideCount;
                updateSlider();
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                updateSlider();
            });

            const minusBtn = document.querySelector('.quantity-btn.minus');
            const plusBtn = document.querySelector('.quantity-btn.plus');
            const quantityInput = document.querySelector('.quantity-input');

            minusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });

            plusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                quantityInput.value = value + 1;
            });
        });

        document.querySelector("form.add-to-cart")?.addEventListener("submit", (e) => {
            e.preventDefault();
            const form = e.target;
            const quantity = form.querySelector("input.quantity-input").value;
            takeAction(form, "PUT", quantity);
        });

        function takeAction(form, method, quantity = null) {
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
                    body: JSON.stringify(quantity ? {
                        product_id,
                        color_id,
                        quantity
                    } : {
                        product_id,
                        color_id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data['success']) {
                        if (data['ac'] === 'store') {
                            const cartCount = document.getElementById("cart_count")
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
