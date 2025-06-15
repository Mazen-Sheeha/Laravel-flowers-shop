<?php

namespace App\Services\Front;

use App\Http\Requests\front\Order\CreateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ZipCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class OrderService
{
    public function index()
    {
        $orders = Order::orderBy('id', "DESC")->where('user_id', Auth::guard('web')->id())->paginate(15);
        return view('front.orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::with(['items.product'])
            ->findOrFail($id);

        return view('front.orders.show', compact('order'));
    }

    public function create()
    {
        $zip_codes = ZipCode::all();

        if ($zip_codes->isEmpty()) {
            return to_route('home')->withErrors(['message' => 'Something wrong']);
        }

        $cartItems = Cart::with(['product', 'color.images'])
            ->where('user_id', Auth::guard('web')->id())
            ->get();
        if (! $cartItems->count()  > 0) return to_route('products.index')->withErrors(['message' => "Cart is empty"]);

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->current_price;
        });

        $shippingCost = 0;

        return view('front.orders.create', compact(
            'zip_codes',
            'cartItems',
            'subtotal',
            'shippingCost',
        ));
    }

    public function store(CreateOrderRequest $request)
    {
        $user = Auth::guard('web')->user();
        $cartItems = Cart::with(['product', 'color'])
            ->where('user_id', $user->id)
            ->get();
        if (! $cartItems->count()  > 0) return to_route('products.index')->withErrors(['message' => "Cart is empty"]);
        try {
            DB::beginTransaction();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->current_price);
            $shipping = ZipCode::where("zip_code", $request->zip_code)->first()->shipping_price;
            if (!$shipping) return back()->withErrors(['message' => "Something wrong"]);
            $total = $subtotal + $shipping;

            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'usd',
                'metadata' => [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]
            ]);

            $order = Order::create([
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'color_id' => $item->color_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->current_price,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();
            DB::commit();

            return to_route('orders.index')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => "Something wrong"]);
        }
    }
}
