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
        Edit
    </span>
@endsection
@section('content')
    <div class="card pb-2 5">
        <form class="card-body grid gap-5" action="{{ route('admins.update', $admin->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Admin name</label>
                <input placeholder="Name" type="text" class="input" name="name"
                    value="{{ is_null(old('name')) ? $admin->name : old('name') }}">
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Email</label>
                <input placeholder="Email" type="email" class="input" name="email"
                    value="{{ is_null(old('email')) ? $admin->email : old('email') }}">
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Password</label>
                <input placeholder="Password" type="password" class="input" name="password">
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">Confirm Password</label>
                <input placeholder="Confirm Password" type="password" class="input" name="password_confirmation">
            </div>
            <button class="btn btn-primary flex justify-center">
                Update
            </button>
        </form>
    </div>
@endsection
