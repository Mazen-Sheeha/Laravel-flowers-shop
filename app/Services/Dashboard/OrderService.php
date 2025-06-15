<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderService
{
    public function index(Request $request)
    {
        if ($request->sorting) {
            $orders = Order::orderBy('status', "DESC")->orderBy('id', 'DESC')->paginate(15);
        } else {
            $orders = Order::orderBy('status')->orderBy('id', 'DESC')->paginate(15);
        }
        return view('dashboard.orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('dashboard.orders.show', compact('order'));
    }

    public function changeStatusToDelivered(string $id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === "pending") {
            $order->status = "delivered";
            $order->save();
        }
        return back()->with("success", 'Order status changed to "delivered" successfully');
    }
}
