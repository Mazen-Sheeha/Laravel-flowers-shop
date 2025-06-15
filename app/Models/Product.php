<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'price',
        'desc',
        'offer',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function offer()
    {
        $offer = $this->offer;
        if ($offer) {
            echo "<div class='offer red'>$offer %</div>";
        }
        echo "";
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}
