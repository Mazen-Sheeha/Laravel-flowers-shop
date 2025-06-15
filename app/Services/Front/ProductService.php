<?php

namespace App\Services\Front;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{


    public function index(Request $request)
    {
        $categories = Category::select("id", 'name')->get();
        $colors = Color::select("id", 'color')->get();
        $db_query = Product::query();
        if ($request->name) {
            $db_query->where("name", "LIKE", "%" . $request->name . "%");
        }
        if ($request->category_id && $request->category_id !== 'all') {
            $db_query->where("category_id", $request->category_id);
        }
        if ($request->color_ids && is_array($request->color_ids)) {
            $db_query->whereHas('colors', function ($query) use ($request) {
                $query->whereIn('colors.id', $request->color_ids);
            });
        }
        if ($request->sorting) {
            switch ($request->sorting) {
                case 'latest':
                    $db_query->orderBy("id", "DESC");
                    break;
                case 'price_up':
                    $db_query->orderBy("current_price", 'DESC');
                    break;
                case 'price_down':
                    $db_query->orderBy("current_price", "ASC");
                    break;
                default:
                    $db_query->orderBy("id", "DESC");
                    break;
            }
        } else {
            $db_query->orderBy("id", "DESC");
        }
        $products = $db_query->with('colors.images')->withCount("cartItems")->paginate(20)->withQueryString();
        if ($request->sorting) {
            $productsCount = Product::count();
        } else {
            $productsCount = $products->total();
        }
        return view('front.products.index', compact('products', 'categories', 'colors', 'colors', 'productsCount'));
    }

    public function show(string $id, Request $request)
    {
        $product = Product::findOrFail($id);
        $cartItem = Cart::select('quantity')->where("product_id", $id)->where('color_id', $request->color_id)->first();
        return view('front.products.show', compact('product', 'cartItem'));
    }
}
