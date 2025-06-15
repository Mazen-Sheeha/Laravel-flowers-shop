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
        Edit
    </span>
@endsection
@section('content')
    <div class="card pb-2 5">
        <form class="card-body grid gap-5" action="{{ route('categories.update', $category->id) }}" id="form"
            method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Category Name</label>
                <input type="text" placeholder="Category name" class="input" name="name"
                    value="{{ is_null(old('name')) ? $category->name : old('name') }}">
            </div>
            <button class="btn btn-primary flex justify-center">
                Update
            </button>
        </form>
    </div>
@endsection
