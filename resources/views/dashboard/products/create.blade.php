@extends('dashboard.layouts.app')
@section('url_pages')
    <span class="text-gray-700">
        Dashboard
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Products
    </span>
    <i class="ki-filled ki-right text-gray-500 text-3xs">
    </i>
    <span class="text-gray-700">
        Create
    </span>
@endsection
@section('style')
    <style>
        .select_color_form_contianer {
            display: flex;
            flex-direction: row;
        }

        .styled_checkbox {
            padding: 10px;
            width: fit-content;
        }

        .styled_checkbox .color_in_checkbox {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
        }

        .styled_checkbox:has(input:checked) .color_in_checkbox {
            opacity: .3;
            border: 1px solid gray
        }

        .card-body:has(.color_circle) {
            position: relative;
        }

        .color_circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .image-label {
            cursor: pointer;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width:768px) {
            .image-label {
                width: 50px;
                height: 50px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="card p-2">
        <form class="card-body grid gap-5" method="POST" action="{{ route('adminProducts.store') }}" id="store-product"
            enctype="multipart/form-data">
            @csrf
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">
                    Product Name
                </label>
                <input class="input" placeholder="Product name" type="text" name="name"
                    value="{{ old('name') }}" />
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">
                    Product Price
                </label>
                <input class="input priceInput" placeholder="Product price" type="text" name="price"
                    value="{{ old('price') }}" />
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">
                    Product Category
                </label>
                <select name="category_id" class="select">
                    <option value="All" disabled selected>All Categories</option>
                    @foreach ($categories as $category)
                        <option class="option" @selected(old('category_id') == $category->id) value="{{ $category->id }}">
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                <label class="form-label max-w-56">
                    Product Description
                </label>
                <textarea name="desc" class="textarea" id="" cols="30" rows="8" name="desc"
                    placeholder="Product description">{{ old('desc') }}</textarea>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div data-accordion="true" data-accordion-expand-all="true">
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                            data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_1_content">
                                <span class="text-base text-gray-900">
                                    Add Offer ?
                                </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block">
                                </i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden">
                                </i>
                            </button>
                            <div class="accordion-content hidden" id="faq_1_content">
                                <div class="text-gray-700 text-md pb-4">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 mb-2.5">
                                        <label class="form-label max-w-40 cursor-pointer" for="offer">
                                            Product Offer
                                        </label>
                                        <input class="input priceInput offer w-14 border-none" placeholder="20"
                                            type="text" name="offer" value="{{ old('offer') }}" id="offer" />%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-4 select_color_form_contianer">
                <div class="card-body justify-center">
                    <div>
                        <div class="w-full flex mb-2">
                            @foreach ($colors as $color)
                                <div class="styled_checkbox">
                                    <input type="checkbox" value="{{ $color->id }}" color="{{ $color->color }}"
                                        style="color:red;" hidden class="color_checkbox" id="{{ $color->id }}"
                                        name="colors[]">
                                    <label class="color_in_checkbox" for="{{ $color->id }}"
                                        style="background-color: {{ $color->color }}"></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" form="store-product" class="btn btn-primary flex justify-center m-5 mt-0">Add</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        const priceInputs = document.querySelectorAll(".priceInput")
        priceInputs.forEach(priceInput => {
            priceInput.addEventListener("input", (e) => {
                return e.target.value = isNaN(+e.target.value) ||
                    (e.target.name === "offer" ? e.target.value.length > 3 : e.target.value.length > 9) ||
                    (e.target.name === 'offer' ? e.target.value > 100 : +e.target.value > 999999999) ?
                    e.target.value.toString().slice(0, -1) :
                    +e.target.value;
            });
        });

        const checkboxes = document.querySelectorAll(".color_checkbox");
        const selectColorsFormContainer = document.querySelector(".select_color_form_contianer .card-body");
        const colors = [];
        const fileLists = {};

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", (e) => {
                const value = e.target.value;
                const color = e.target.getAttribute("color");
                if (colors.includes(color)) {
                    const formDiv = selectColorsFormContainer.querySelector(`#color-${value}`);
                    formDiv.remove();
                    delete fileLists[value];
                    colors.splice(colors.indexOf(color), 1);
                } else {
                    const newDiv = document.createElement('div');
                    newDiv.classList = "card mb-3";
                    newDiv.id = "color-" + value;
                    newDiv.innerHTML = `
                    <div class="card-body">
                        <span class="color_circle" style="background-color:${color}; display: flex; align-items:center; justify-content: center; cursor:pointer;" onclick="removeColor('${color}')">&times</span>
                        <label for="color-${color}" >
                            <img src="{{ asset('images/upload_area.png') }}" class="image-label" alt="">
                        </label>
                        <input id="color-${color}" hidden name="image-[${value}][]" type="file" multiple onchange="handleImageChange(event, '${value}')">
                        <div class="preview-container" id="preview-${value}" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;"></div>
                    </div>
                `;
                    selectColorsFormContainer.appendChild(newDiv);
                    fileLists[value] = [];
                    colors.push(color);
                }
            });
        });

        function handleImageChange(event, colorValue) {
            const input = event.target;
            const previewContainer = document.getElementById(`preview-${colorValue}`);
            const files = Array.from(input.files);

            previewContainer.innerHTML = '';
            fileLists[colorValue] = files;

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.style.position = "relative";
                    imgWrapper.innerHTML = `
                    <img src="${e.target.result}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px;" />
                    <button onclick="removeImage('${colorValue}', ${index})" type="button"
                        class="remove-btn">
                        &times;
                    </button>
                `;
                    previewContainer.appendChild(imgWrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeImage(colorValue, index) {
            fileLists[colorValue].splice(index, 1);

            const input = document.getElementById(`color-${colorValue}`);
            const dt = new DataTransfer();

            fileLists[colorValue].forEach(file => {
                dt.items.add(file);
            });

            input.files = dt.files;
            handleImageChange({
                target: input
            }, colorValue);
        }

        function removeColor(color) {
            const checkbox = document.querySelector("[color='" + color + "']")
            checkbox.click();
        }
    </script>
@endsection
