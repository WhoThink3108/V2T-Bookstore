<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /* =========================================================================
     * 1. DASHBOARD CHÍNH
     * ========================================================================= */
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $totalUsers = User::count();

        $topBooks = Book::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(3)
            ->get();

        $recentOrders = Order::with(['user', 'books'])->latest()->limit(5)->get();

        $monthlyRevenueData = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyRevenueData[$i] ?? 0;
        }

        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalUsers', 'topBooks', 'recentOrders', 'chartData'));
    }

    /* =========================================================================
     * 2. QUẢN LÝ KHO SÁCH
     * ========================================================================= */
    public function booksIndex()
    {
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $lowStock = Book::where('stock', '<', 10)->count();
        
        // Đã khóa chặt theo năm hiện tại tránh lỗi cộng gộp dữ liệu năm cũ
        $monthlyRevenue = Order::where('status', 'completed')
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->sum('total_price');

        $books = Book::withAvg('reviews', 'rating')->latest()->paginate(10);

        return view('admin.books', compact('books', 'totalBooks', 'totalStock', 'lowStock', 'monthlyRevenue'));
    }

    public function booksCreate()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Bạn không có quyền truy cập vào khu vực này!');
        }
        $categories = Category::all(); 
        return view('admin.books_create', compact('categories'));
    }

    public function booksStore(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Bạn không có quyền truy cập vào khu vực này!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề sách.',
            'author.required' => 'Vui lòng nhập tên tác giả.',
            'category_id.required' => 'Vui lòng chọn danh mục cho cuốn sách này.',
            'price.required' => 'Vui lòng nhập giá bán.',
            'stock.required' => 'Vui lòng nhập số lượng tồn kho.',
            'image_url.url' => 'Địa chỉ đường dẫn ảnh không hợp lệ.',
        ]);

        $slug = Str::slug($request->title);
        $count = Book::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        Book::create([
            'title' => $request->title,
            'slug' => $slug,
            'author' => $request->author,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $request->image_url ?? 'https://placehold.co/400x600/10b981/ffffff?text=V2T+Bookstore',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', '🎉 Thêm cuốn sách mới vào kho hàng thành công rồi nhé!');
    }

    public function booksEdit($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Bạn không có quyền truy cập vào khu vực này!');
        }
        $book = Book::findOrFail($id);
        $categories = Category::all(); 
        return view('admin.books_edit', compact('book', 'categories'));
    }

    public function booksUpdate(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Bạn không có quyền truy cập vào khu vực này!');
        }

        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ], [
            'title.required' => 'Tiêu đề sách không được để trống.',
            'author.required' => 'Tên tác giả không được để trống.',
            'price.required' => 'Vui lòng nhập giá tiền.',
            'stock.required' => 'Vui lòng nhập số lượng tồn kho.',
        ]);

        $slug = Str::slug($request->title);
        $count = Book::where('slug', $slug)->where('id', '!=', $id)->count();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        $book->update([
            'title' => $request->title,
            'slug' => $slug,
            'author' => $request->author,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $request->image_url ?? 'https://placehold.co/400x600/10b981/ffffff?text=V2T+Bookstore',
            'description' => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', '🎉 Cập nhật thông tin cuốn sách thành công!');
    }

    public function booksDestroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Bạn không có quyền truy cập vào khu vực này!');
        }
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', '🗑️ Đã xóa cuốn sách khỏi hệ thống thành công!');
    }

    /* =========================================================================
     * 3. QUẢN LÝ ĐƠN HÀNG
     * ========================================================================= */
    public function ordersIndex(Request $request)
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $shippingOrders = Order::where('status', 'shipping')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        $query = Order::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $cleanSearchId = str_replace('INK-', '', $search);
                $q->where('id', 'like', '%' . $cleanSearchId . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.orders', compact('orders', 'totalOrders', 'pendingOrders', 'shippingOrders', 'completedOrders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,shipping,completed',
        ]);
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }

    /* =========================================================================
     * 4. QUẢN LÝ NGƯỜI DÙNG
     * ========================================================================= */
    public function usersIndex()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users', 'totalUsers', 'activeUsers'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 'active' ? 'blocked' : 'active';
        $user->save();
        return back()->with('success', 'Đã cập nhật trạng thái tài khoản người dùng thành công!');
    }

    public function usersShow($id)
    {
        $user = User::findOrFail($id);
        $orderCount = Order::where('user_id', $id)->count();
        $totalSpent = Order::where('user_id', $id)->where('status', 'completed')->sum('total_price');
        return view('admin.users_show', compact('user', 'orderCount', 'totalSpent'));
    }

    /* =========================================================================
     * 5. QUẢN LÝ NHÀ CUNG CẤP (SUPPLIERS)
     * ========================================================================= */
    public function suppliersIndex()
    {
        $totalSuppliers = Supplier::count();
        $activeSuppliers = Supplier::where('status', 'active')->count();
        $pausedSuppliers = Supplier::where('status', 'paused')->count();
        $suppliers = Supplier::latest()->paginate(10);

        return view('admin.suppliers.index', compact('suppliers', 'totalSuppliers', 'activeSuppliers', 'pausedSuppliers'));
    }

    public function suppliersCreate()
    {
        return view('admin.suppliers.create');
    }

    public function suppliersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contract_code' => 'required|string|max:255|unique:suppliers,contract_code',
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'status' => 'required|in:active,paused',
        ]);

        Supplier::create($request->all());
        return redirect()->route('admin.suppliers.index')->with('success', '🎉 Thêm nhà cung cấp mới thành công!');
    }

    public function suppliersEdit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function suppliersUpdate(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'contract_code' => 'required|string|max:255|unique:suppliers,contract_code,' . $id,
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'status' => 'required|in:active,paused',
        ]);

        $supplier->update($request->all());
        return redirect()->route('admin.suppliers.index')->with('success', '🎉 Cập nhật thông tin nhà cung cấp thành công!');
    }

    public function suppliersDestroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', '🗑️ Đã xóa nhà cung cấp khỏi hệ thống!');
    }

    /* =========================================================================
     * 6. QUẢN LÝ ĐÁNH GIÁ (REVIEWS) - ĐÃ BỔ SUNG ĐẦY ĐỦ TẠI ĐÂY
     * ========================================================================= */
    public function reviewsIndex(Request $request)
    {
        $totalCount = Review::count();
        $pendingCount = Review::where('status', 'pending')->count();
        $avgRating = round(Review::where('status', 'approved')->avg('rating') ?? 0, 1);
        $violatedCount = Review::where('status', 'violated')->count();

        $query = Review::with(['book', 'user']);
        
        if ($request->has('tab') && in_array($request->tab, ['pending', 'approved', 'violated'])) {
            $query->where('status', $request->tab);
        }

        $reviews = $query->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews', 'totalCount', 'pendingCount', 'avgRating', 'violatedCount'));
    }

    public function reviewsApprove($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 'approved']);
        return back()->with('success', '🎉 Phê duyệt đánh giá của khách hàng thành công!');
    }

    public function reviewsReply(Request $request, $id)
    {
        $request->validate(['admin_reply' => 'required|string']);
        $review = Review::findOrFail($id);
        $review->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'approved' 
        ]);
        return back()->with('success', '🎉 Gửi phản hồi đến khách hàng thành công!');
    }

    public function reviewsViolate($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 'violated']);
        return back()->with('success', '🛡️ Đã đánh dấu đánh giá này là Vi phạm / Spam.');
    }

    public function reviewsDestroy($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', '🗑️ Đã xóa vĩnh viễn đánh giá khỏi hệ thống!');
    }
}