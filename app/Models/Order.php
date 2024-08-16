<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function printify_cart()
    {
        $order_products = Cart::where('order_id', $this->id)
        ->where('image_path', 'like', '%printify%')
        ->get();
        return $order_products;

    }
}
