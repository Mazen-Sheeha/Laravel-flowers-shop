<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\Product\CreateProductRequest;
use App\Http\Requests\dashboard\Product\UpdateProductRequest;
use App\Services\Dashboard\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        return $this->productService = $productService;
    }

    public function index(Request $request)
    {
        return $this->productService->index($request);
    }

    public function create()
    {
        return $this->productService->create();
    }

    public function store(CreateProductRequest $request)
    {
        return $this->productService->store($request);
    }

    public function show(string $id)
    {
        return $this->productService->show($id);
    }

    public function edit(string $id)
    {
        return $this->productService->edit($id);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        return $this->productService->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->productService->destroy($id);
    }
}
