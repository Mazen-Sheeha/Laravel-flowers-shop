<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\Category\CreateCategoryRequest;
use App\Http\Requests\Dashboard\Category\UpdateCategoryRequest;
use App\Models\Category;

class CategoryService
{

    public function index()
    {
        $categories = Category::orderBy('id', "DESC")->select('id', 'name')->paginate(15);
        return view("dashboard.categories.index", compact('categories'));
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view("dashboard.categories.show", compact("category"));
    }

    public function create()
    {
        return view("dashboard.categories.create");
    }

    public function store(CreateCategoryRequest $request)
    {
        $validated = $request->validated();
        Category::create($validated);
        return back()->with("success", "Category created successfully");
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view("dashboard.categories.edit", compact('category'));
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $validated = $request->validated();
        $category = Category::findOrFail($id);
        $category->update($validated);
        $category->save();
        return to_route("categories.index")->with("success", "Category updated successfully");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return to_route("categories.index")->with("success", "Category deleted successfully");
    }

    public function products(string $id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products();
        return view("dashboard.products.index", compact('products'));
    }
}
