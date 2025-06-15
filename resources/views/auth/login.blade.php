@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Login
@endsection
@section('content')
    <form action="{{ route('login') }}" class="app_form" method="post">
        @csrf
        <h1>Login</h1>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" required class="form-control" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" required class="form-control" id="password" name="password">
        </div>
        <button>Login</button>
        <a href="{{ route('register.show') }}">Don't have an account?</a>
    </form>
@endsection
