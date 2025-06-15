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
        Create
    </span>
@endsection
@section('content')
    <div class="card pb-2 5">
        <form class="card-body grid gap-5" action="{{ route('admins.store') }}" method="post">
            @csrf
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Admin name</label>
                <input type="text" class="input" name="name" value="{{ old('name') }}" placeholder="Name">
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Email</label>
                <input type="email" class="input" name="email" value="{{ old('email') }}" placeholder="Email">
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Password</label>
                <input type="password" class="input" name="password" placeholder="Password">
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Confirm Password</label>
                <input type="password" class="input" name="password_confirmation" placeholder="Confirm Password">
            </div>
            <button class="btn btn-primary flex justify-center">
                Add
            </button>
        </form>
    </div>
@endsection
