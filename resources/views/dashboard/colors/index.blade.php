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
@endsection
@section('content')
    <div class="card bg-white shadow-sm rounded-lg border border-gray-200 flex">
        <div class="card-body p-6">
            <form action="{{ route('colors.store') }}" method="post" enctype="multipart/form-data"
                class="flex flex-col md:flex-row items-center gap-6">
                @csrf
                <div class="flex items-center">
                    <i class="fas fa-palette text-blue-500 me-3 text-xl"></i>
                    <h5 class="text-gray-800 font-semibold">Add New Color</h5>
                </div>
                <div class="flex items-center relative">
                    <div class="relative">
                        <label for="color" id="colorPreview"
                            style="width: 40px; height: 40px; background-color: rgba(0, 0, 255, 0.5)"
                            class="rounded-full shadow-sm inline-block bg-blue-500 cursor-pointer transition-all duration-200 ease-in-out border border-blue-700">
                            <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 border border-gray-200">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>

                        </label>
                    </div>
                    <input type="color" name="color" id="color" value="#3b82f6" hidden>
                </div>
                <button type="submit"
                    class="btn btn-light hover:bg-blue-600 text-white px-4 py-2 rounded-md md:ml-auto transition-colors duration-200">
                    <i class="fas fa-plus me-2"></i> Add Color
                </button>
            </form>
        </div>
    </div>
    <div class="card min-w-full mt-7">
        <div class="card-header">
            <h3 class="card-title">
                Colors
            </h3>
        </div>
        <div class="card-table scrollable-x-auto">
            @if (count($colors) === 0)
                <h3 class="text-center p-4">No Colors</h3>
            @else
                <div class="scrollable-auto">
                    <table class="table align-middle text-2sm text-gray-600">
                        <tr class="bg-gray-100">
                            <th class="text-start font-medium min-w-10">#</th>
                            <th class="text-start font-medium min-w-15">Color</th>
                            <th class="min-w-16">Actions</th>
                        </tr>
                        @foreach ($colors as $color)
                            <tr>
                                <td>
                                    {{ $color->id }}
                                </td>
                                <td>
                                    <div class="inline-flex items-center gap-3">
                                        <div class="rounded-full w-7 h-7 border border-gray-200"
                                            style="background-color: {{ $color->color }}"></div>
                                        <span>{{ $color->color }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="menu inline-flex" data-menu="true">
                                        <div class="menu-item" data-menu-item-offset="0, 10px"
                                            data-menu-item-placement="bottom-end"
                                            data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                            data-menu-item-trigger="click|lg:click">
                                            <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                                <i class="ki-filled ki-dots-vertical">
                                                </i>
                                            </button>
                                            <div class="menu-dropdown menu-default w-full max-w-[175px]"
                                                data-menu-dismiss="true">
                                                <div class="menu-item">
                                                    <a class="menu-link" href="{{ route('colors.edit', $color->id) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-pencil">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            Edit
                                                        </span>
                                                    </a>
                                                </div>
                                                <form class="menu-item" action="{{ route('colors.destroy', $color->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="menu-link" href="#">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-trash">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            Remove
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
        <div class="card-footer justify-center">
            {{ $colors->links() }}
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
