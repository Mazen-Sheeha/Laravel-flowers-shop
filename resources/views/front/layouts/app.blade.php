@toastifyCss
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    @yield('style')
    <style>
        .hero_section {
            background-image: url("../images/bg.jpeg");
        }
    </style>
</head>

<body>

    {{-- App Start --}}
    <div class="app_container">
        {{-- Including Toastify blade with its logic --}}
        @include('inc.message')

        {{-- Header Section Start --}}
        <header>
            <nav>
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Image">
                </a>

                {{-- Collpase ( For devices wich smaller than 768px ) --}}
                <div class="collapse " id="collapse_btn">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

                {{-- Nav Links --}}
                <ul class="nav_links" id="nav_links">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('messages.create') }}">Contact Us</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">About Us</a>
                    </li>
                    @if (auth()->guard('web')->check())
                        <li class="none">
                            <a href="{{ route('orders.index') }}">Orders</a>
                        </li>
                        <li class="none">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button>Logout <i class="fa-solid fa-arrow-right-from-bracket icon"></i></button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login.show') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register.show') }}">Register</a>
                        </li>
                    @endif
                    @if (auth()->guard('web')->check())
                        <div class="dropdown" id="dropdown">
                            <div>
                                <span>{{ auth()->guard('web')->user()->name }}</span>
                                <i class="fa-solid fa-caret-down" id="dropdown_icon"></i>
                            </div>
                            <ul class="profile_list none" id="profile_list">
                                <li>
                                    <a href="{{ route('orders.index') }}">Orders</a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="cart">
                            <a href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping icon"></i>
                            </a>
                            @php
                                $cartItemsCount = auth()->guard('web')->user()->cartItemsCount();
                            @endphp
                            <div class="cart_count {{ !$cartItemsCount ? 'none' : '' }}" id="cart_count">
                                {{ $cartItemsCount }}</div>
                        </div>
                    @endif
                </ul>
            </nav>
        </header>
        {{-- Header Section End --}}

        {{-- App Content Section Start --}}
        @yield('content')
        {{-- App Content Section End --}}

        {{-- Footer Section Start --}}
        <footer>

            <div class="footer_column fade-in">
                <h2>Quick Links</h2>
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('messages.create') }}">Contact Us</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">About Us</a>
                    </li>
                </ul>
            </div>
            <div class="footer_column fade-in">
                <h2>Account Links</h2>
                <ul>
                    <li>
                        <a href="{{ route('login.show') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register.show') }}">Register</a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}">Cart</a>
                    </li>
                </ul>
            </div>
            <div class="footer_column fade-in">
                <h2>Get In Touch</h2>
                <ul>
                    @if ($information->phone)
                        @php
                            $onlyDigits = preg_replace('/\D/', '', $information->phone);
                            $telPhone = strlen($onlyDigits) === 10 ? '+1' . $onlyDigits : '+' . $onlyDigits;
                        @endphp
                        <li>
                            <a href="tel:{{ $telPhone }}">{{ $information->phone }}</a>
                        </li>
                    @else
                        <li>
                            <a href="tel:{{ $telPhone }}">+1 (313) 799-1066</a>
                        </li>
                    @endif
                    @if ($information->email)
                        <li>
                            <a href="mailto:{{ $information->email }}">{{ $information->email }}
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="icons">
                    <a href="https://www.instagram.com/sarifloral/?igsh=Z2FzdmYyMXc3NW84" target="blank">
                        <i class="fa-brands fa-instagram icon"></i>
                    </a>
                </div>
            </div>
            <div class="footer_column fade-in">
                <img src="{{ asset('images/logo.png') }}" alt="" class="logo">
            </div>
        </footer>
        {{-- Footer Section End --}}
        @include('inc.loader')
    </div>
    {{-- App End --}}

    {{-- Main Js File --}}
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('script')
</body>

</html>
@toastifyJs
