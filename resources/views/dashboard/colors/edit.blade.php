@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Colors
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Edit
    </span>
@endsection
@section('content')
    <div class="card bg-white shadow-sm rounded-lg border border-gray-200 flex">
        <div class="card-body p-6">
            <form action="{{ route('colors.update', $color->id) }}" enctype="multipart/form-data"
                class="flex flex-col md:flex-row items-center gap-6" method="POST">
                @method('PUT')
                @csrf
                <div class="flex items-center">
                    <i class="fas fa-palette text-blue-500 me-3 text-xl"></i>
                    <h5 class="text-gray-800 font-semibold">Update Color</h5>
                </div>
                <div class="flex items-center relative">
                    <div class="relative">
                        <label for="color" id="colorPreview"
                            style="width: 40px; height: 40px; background-color: {{ old('color') ? old('color') : $color->color }}"
                            class="rounded-full shadow-sm inline-block bg-blue-500 cursor-pointer transition-all duration-200 ease-in-out border border-blue-700">
                            <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 border border-gray-200">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>

                        </label>
                    </div>
                    <input type="color" name="color" id="color"
                        value="{{ old('color') ? old('color') : $color->color }}" hidden>
                </div>
                <button type="submit"
                    class="btn btn-light hover:bg-blue-600 text-white px-4 py-2 rounded-md md:ml-auto transition-colors duration-200">
                    <i class="ki-filled ki-pencil"></i> Update Color
                </button>
            </form>
        </div>
    </div>
@section('script')
    <script>
        const colorInput = document.getElementById('color');
        const preview = document.getElementById('colorPreview');
        colorInput.addEventListener('input', function() {
            preview.style.backgroundColor = this.value;
        });
    </script>
@endsection
@endsection
