<?php

namespace App\Services\Front;

use App\Models\Product;

class FrontService
{
    public function home()
    {
        $products = Product::with('colors.images')->orderBy('id', 'DESC')->paginate(8);
        return view('front.home', compact('products'));
    }

    public function contact()
    {
        return view('front.contact_us');
    }

    public function about()
    {
        return view('front.about_us');
    }
}
