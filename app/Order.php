<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'recipient_name',
        'shipping_address',
        'shipping_price',
        'order_code',
        'track_code',
        'courier_name',
        'unique_code',
        'total_price',
        'user_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
