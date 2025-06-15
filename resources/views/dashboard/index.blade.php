@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Home
    </span>
@endsection
@section('content')
    <div
        style="display: flex; flex-direction: column;width:100%; min-height: calc(100% - 60px); align-items: center; justify-content: center">
        <img src="{{ asset('images/logo.png') }}" width="400" alt="">
        <span style="color: #bb9c20; font-size: 2rem; margin-top: -30px; font-family: serif;">Admin Dashboard</span>
    </div>
@endsection
