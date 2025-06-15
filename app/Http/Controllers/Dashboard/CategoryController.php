<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CreateCategoryRequest;
use App\Http\Requests\Dashboard\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Dashboard\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        return $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->index();
    }

    public function show(string $id)
    {
        return $this->categoryService->show($id);
    }

    public function create()
    {
        return $this->categoryService->create();
    }

    public function store(CreateCategoryRequest $request)
    {
        return $this->categoryService->store($request);
    }

    public function edit(string $id)
    {
        return $this->categoryService->edit($id);
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        return  $this->categoryService->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->categoryService->destroy($id);
    }

    public function products(string $id)
    {
        return $this->categoryService->products($id);
    }
}
