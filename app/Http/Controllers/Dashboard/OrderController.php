<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        return $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        return $this->orderService->index($request);
    }

    public function show(string $id)
    {
        return $this->orderService->show($id);
    }

    public function changeStatusToDelivered(string $id)
    {
        return $this->orderService->changeStatusToDelivered($id);
    }
}
