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
@endsection
@section('content')
    <div class="card min-w-full">
        <div class="card-header">
            <h3 class="card-title">
                Categories
            </h3>
            <div class="flex items-center gap-5">
                <div class="menu" data-menu="true">
                    <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-start"
                        data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
                        <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                            <i class="ki-filled ki-dots-vertical">
                            </i>
                        </button>
                        <div class="menu-dropdown menu-default w-full max-w-[175px]" data-menu-dismiss="true">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('categories.create') }}">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-add-files">
                                        </i>
                                    </span>
                                    <span class="menu-title">
                                        Add
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-table scrollable-x-auto">
            <div class="scrollable-auto">
                @if (count($categories) == 0)
                    <h5 class="p-3 text-center">No Categories</h5>
                @else
                    <table class="table align-middle text-2sm text-gray-600">
                        <tr class="bg-gray-100">
                            <th class="text-start font-medium min-w-10">#</th>
                            <th class="text-start font-medium min-w-56">Name</th>
                            <th class="text-start font-medium min-w-56">Products</th>
                            <th class="min-w-16">Actions</th>
                        </tr>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->id }}
                                </td>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    <a href="{{ route('adminProducts.index', ['category_id' => $category->id]) }}"
                                        style="color:blue; text-decoration: underline;">Category
                                        Products</a>
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
                                                    <a class="menu-link"
                                                        href="{{ route('categories.show', $category->id) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-search-list">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            View
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-separator">
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link"
                                                        href="{{ route('categories.edit', $category->id) }}">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-pencil">
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">
                                                            Edit
                                                        </span>
                                                    </a>
                                                </div>
                                                <form class="menu-item"
                                                    action="{{ route('categories.destroy', $category->id) }}"
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
            {{ $categories->links() }}
        </div>
    </div>
@endsection
