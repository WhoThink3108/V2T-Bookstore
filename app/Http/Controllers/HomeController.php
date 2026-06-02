<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Sách mới phát hành
        $newBooks = Book::withAvg('reviews', 'rating')->latest()->take(4)->get();

        // 2. Sách nổi bật (Điểm trung bình rating cao nhất)
        $featuredBooks = Book::withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(4)
            ->get();

        // 3. Sách bán chạy nhất (Được đặt nhiều nhất trong order_items)
        $bestSellers = Book::withAvg('reviews', 'rating')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(4)
            ->get();

        // 4. Ý kiến khách hàng (Lấy các đánh giá tích cực 4-5 sao)
        $customerReviews = \App\Models\Review::with(['user', 'book'])
            ->where('rating', '>=', 4)
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        // Nếu chưa có đánh giá được duyệt, lấy đánh giá chung
        if ($customerReviews->isEmpty()) {
            $customerReviews = \App\Models\Review::with(['user', 'book'])
                ->where('rating', '>=', 4)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('home', compact('newBooks', 'featuredBooks', 'bestSellers', 'customerReviews'));
    }
}