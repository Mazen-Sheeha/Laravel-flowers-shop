<?php

namespace App\Services\Front;

use App\Http\Requests\Front\Cart\AddAndDeleteCartItemRequest;
use App\Http\Requests\Front\Cart\UpdateCartRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private $userId;

    public function __construct()
    {
        $this->userId = Auth::guard('web')->user()->id;
    }

    private function getSpecificCartItem($color_id, $product_id)
    {
        $item = Cart::where("user_id", $this->userId)
            ->where('product_id', $product_id)
            ->where('color_id', $color_id)
            ->first();
        return $item;
    }

    public function index()
    {
        $cartItems = Cart::with('product')->with('color.images')->orderBy('id', "DESC")->select("id", 'product_id', 'quantity', 'color_id')
            ->where("user_id", $this->userId)
            ->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->current_price;
        });
        return view("front.cart", compact('cartItems', 'subtotal'));
    }

    public function store(AddAndDeleteCartItemRequest $request)
    {
        $validated = $request->validated();
        $item = $this->getSpecificCartItem($validated['color_id'], $validated['product_id']);
        if ($item) {
            $item->quantity = ++$item->quantity;
            $item->save();
            return response()->json(['success' => true, "message" => "This product quantity in cart became $item->quantity"]);
        } else {
            Cart::create([
                'user_id' => $this->userId,
                'product_id' => $validated['product_id'],
                'color_id' => $validated['color_id'],
                'quantity' => isset($validated['quantity']) ? $validated['quantity'] : 1
            ]);
            return response()->json(['success' => true, "message" => 'Product added to cart successfully', 'ac' => 'store']);
        }
        return response()->json(['message' => "Something wrong"]);
    }

    public function update(UpdateCartRequest $request)
    {
        $validated = $request->validated();
        $item = $this->getSpecificCartItem($validated['color_id'], $validated['product_id']);
        if ($item) {
            $item->quantity = $validated['quantity'];
            $item->save();
        } else {
            Cart::create([
                'user_id' => $this->userId,
                'product_id' => $validated['product_id'],
                'color_id' => $validated['color_id'],
                'quantity' => $validated['quantity']
            ]);
            return response()->json(['success' => true, 'message' => 'Product has been added successfully', 'ac' => 'store']);
        }
        return response()->json(['success' => true, 'message' => 'Quantity of product in cart has been changed successfully']);
    }

    public function destroy(AddAndDeleteCartItemRequest $request)
    {
        $validated = $request->validated();
        $item = $this->getSpecificCartItem($validated['color_id'], $validated['product_id']);
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Product has been removed from cart successfully']);
    }
}
