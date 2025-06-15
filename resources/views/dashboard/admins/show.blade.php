@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Admins
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        {{ $admin->name }}
    </span>
@endsection
@section('content')
    <div class="card p-5">
        <div>
            Name : {{ $admin->name }}
        </div>
        <div>
            Email : {{ $admin->email }}
        </div>
    </div>
@endsection
