<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        // 1. Kiểm tra user đã mua sách này chưa
        $hasPurchased = OrderItem::where('book_id', $bookId)
            ->whereHas('order', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Bạn cần mua sách này trước khi đánh giá!');
        }

        // 2. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ], [
            'comment.required' => 'Bạn vui lòng viết một vài lời nhận xét nhé!',
            'rating.required' => 'Bạn quên chọn số sao đánh giá rồi.'
        ]);

        // 3. Lưu trực tiếp vào bảng reviews
        Review::create([
            'book_id' => $bookId,
            'user_id' => Auth::id(),
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', '🎉 Cảm ơn bạn đã để lại đánh giá cho cuốn sách này!');
    }
}