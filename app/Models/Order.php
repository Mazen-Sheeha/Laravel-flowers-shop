<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'fullname',
        'email',
        'phone',
        'address',
        'zip_code',
        'total',
        'shipping_cost',
        'payment_method',
        'payment_intent_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function items()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
