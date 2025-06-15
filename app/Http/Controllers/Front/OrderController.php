<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\front\Order\CreateOrderRequest;
use App\Services\Front\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return $this->orderService->index();
    }

    public function show(string $id)
    {
        return $this->orderService->show($id);
    }

    public function create()
    {
        return $this->orderService->create();
    }

    public function store(CreateOrderRequest $request)
    {
        return $this->orderService->store($request);
    }
}
