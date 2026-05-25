<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ], [
            'comment.required' => 'Bạn vui lòng viết một vài lời nhận xét nhé!',
            'rating.required' => 'Bạn quên chọn số sao đánh giá rồi.'
        ]);

        // 2. Lưu trực tiếp vào bảng reviews
        Review::create([
            'book_id' => $bookId,
            'user_id' => Auth::id(), // ID của người dùng đang đăng nhập
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', '🎉 Cảm ơn bạn đã để lại đánh giá cho cuốn sách này!');
    }
}