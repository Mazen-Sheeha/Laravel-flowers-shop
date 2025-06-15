<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\Cart\AddAndDeleteCartItemRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Cart\UpdateCartRequest;
use App\Services\Front\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        return $this->cartService = $cartService;
    }

    public function index()
    {
        return $this->cartService->index();
    }

    public function store(AddAndDeleteCartItemRequest $request)
    {
        return $this->cartService->store($request);
    }

    public function update(UpdateCartRequest $request)
    {
        return $this->cartService->update($request);
    }

    public function destroy(AddAndDeleteCartItemRequest $request)
    {
        return $this->cartService->destroy($request);
    }
}
