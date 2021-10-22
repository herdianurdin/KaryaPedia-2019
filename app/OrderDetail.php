<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'total_order',
        'total_price',
        'order_id',
        'product_id'
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
