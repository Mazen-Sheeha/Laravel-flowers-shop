<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
