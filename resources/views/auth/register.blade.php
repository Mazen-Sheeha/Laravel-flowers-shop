@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Register
@endsection
@section('content')
    <form action="{{ route('register') }}" class="app_form" method="post">
        @csrf
        <h1>Register</h1>
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" required class="form-control" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" required class="form-control" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" required class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" required class="form-control" name="password_confirmation" id="password_confirmation">
        </div>
        <button>Register</button>
        <a href="{{ route('login.show') }}">Have an account?</a>
    </form>
@endsection
