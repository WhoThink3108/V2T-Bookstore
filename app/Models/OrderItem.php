<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 
        'book_id', 
        'quantity', 
        'price'
    ];

    // Một chi tiết đơn hàng thì thuộc về một cuốn sách
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Một chi tiết đơn hàng thuộc về một đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}