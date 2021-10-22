<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   
    protected $fillable = [
        'name',
        'category',
        'image',
        'weight',
        'price',
        'stock',
        'permalink'
    ];

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
}
