<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // THÊM DÒNG NÀY: Mở khóa quyền lưu dữ liệu hàng loạt cho các cột trong bảng books
    protected $fillable = [
        'title', 
        'slug', // BỔ SUNG: Mở khóa quyền ghi dữ liệu cho cột slug
        'author', 
        'category_id', 
        'price', 
        'stock', 
        'image_url', 
        'description'
    ];

    // Mối quan hệ với bảng reviews mà chúng ta đã làm ở bước trước
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        // Sử dụng chính bảng order_items làm cầu nối Nhiều - Nhiều giữa Sách và Đơn hàng
        return $this->belongsToMany(Order::class, 'order_items', 'book_id', 'order_id');
    }
}