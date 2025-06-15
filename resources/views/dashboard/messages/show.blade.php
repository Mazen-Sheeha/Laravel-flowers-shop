@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Categories
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        {{ $category->name }}
    </span>
@endsection
@section('content')
    <div class="card p-5">
        Category name : {{ $category->name }}
    </div>
@endsection
