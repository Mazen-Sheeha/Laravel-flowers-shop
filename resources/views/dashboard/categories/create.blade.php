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
        Create
    </span>
@endsection
@section('content')
    <div class="card pb-2 5">
        <form class="card-body grid gap-5" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">
                    Category Name
                </label>
                <input class="input" placeholder="Category name" type="text" value="" name="name"
                    value="{{ old('name') }}" />
            </div>
            <button class="btn btn-primary flex justify-center">
                Add
            </button>
        </form>
    </div>
@endsection
