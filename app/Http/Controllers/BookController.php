<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // 1. Logic trang Cửa hàng tích hợp Sắp xếp + Lọc Danh mục + Lọc Tác giả động
    public function index(Request $request)
    {
        // Khởi tạo query lấy dữ liệu từ bảng books
        // $query = Book::query();
        $query = Book::withAvg('reviews', 'rating');

        // CHỨC NĂNG 1: Lọc theo Danh mục sách (?category=id)
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // CHỨC NĂNG 2: Tìm kiếm theo từ khóa (?search=từ_khóa)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('author', 'like', '%' . $searchTerm . '%');
            });
        }

        // CHỨC NĂNG 3: Lọc theo Tác giả thực tế từ URL (?author=Tên_Tác_Giả)
        if ($request->has('author') && $request->author != '') {
            $query->where('author', $request->author);
        }

        // CHỨC NĂNG 4: Xử lý Sắp xếp động (?sort=loại_sắp_xếp)
        $sortType = $request->input('sort', 'newest'); // Mặc định là sách mới nhất
        if ($sortType == 'price_asc') {
            $query->orderBy('price', 'asc');   // Giá tăng dần
        } elseif ($sortType == 'price_desc') {
            $query->orderBy('price', 'desc');  // Giá giảm dần
        } else {
            $query->latest();                  // Mới phát hành lên đầu
        }

        // Thực hiện phân trang và giữ lại toàn bộ tham số lọc trên URL thanh địa chỉ
        $books = $query->paginate(9)->withQueryString();
        
        // Lấy toàn bộ danh mục từ DB đổ ra Sidebar
        $categories = Category::all();

        // BÍ KÍP ĐỘNG: Lấy danh sách các Tác giả duy nhất (Distinct) đang thực sự có sách trong DB để làm bộ lọc
        $authors = Book::select('author')->distinct()->pluck('author');

        return view('shop', compact('books', 'categories', 'authors'));
    }

    // 2. Logic trang Chi tiết sách (Giữ nguyên)
    public function show($id)
    {
        // Thay dòng cũ thành dòng này để lấy thêm danh sách reviews và user viết review đó
        $book = Book::with(['reviews.user'])->withAvg('reviews', 'rating')->findOrFail($id);

        // Lấy thêm 4 cuốn sách ngẫu nhiên cùng danh mục làm sách liên quan (Giữ nguyên)
        $relatedBooks = Book::where('category_id', $book->category_id)
                            ->where('id', '!=', $book->id)
                            ->take(4)
                            ->get();

        // Kiểm tra user đã mua sách này chưa (để cho phép đánh giá)
        $hasPurchased = false;
        if (Auth::check()) {
            $hasPurchased = OrderItem::where('book_id', $id)
                ->whereHas('order', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                ->exists();
        }

        return view('detail', compact('book', 'relatedBooks', 'hasPurchased'));
    }
}