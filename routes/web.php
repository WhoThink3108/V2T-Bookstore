<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

// 1. Công khai
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');

// 2. Auth (Login/Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// 3. Nhóm yêu cầu Đăng nhập (User)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Giỏ hàng & Thanh toán
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'placeOrder'])->name('cart.placeOrder');

    Route::post('/book/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // 4. Nhóm Quản trị (Admin)
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Quản lý sách
        Route::get('/books', [AdminController::class, 'booksIndex'])->name('admin.books.index');
        Route::get('/books/create', [AdminController::class, 'booksCreate'])->name('admin.books.create');
        Route::post('/books/store', [AdminController::class, 'booksStore'])->name('admin.books.store');
        Route::get('/books/{id}/edit', [AdminController::class, 'booksEdit'])->name('admin.books.edit');
        Route::put('/books/{id}', [AdminController::class, 'booksUpdate'])->name('admin.books.update');
        Route::delete('/books/{id}', [AdminController::class, 'booksDestroy'])->name('admin.books.destroy');

        // Đơn hàng
        Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('admin.orders.index');
        Route::post('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');

        // Nhà cung cấp
        Route::get('/suppliers', [AdminController::class, 'suppliersIndex'])->name('admin.suppliers.index');

        // Quản lý người dùng
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
        Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggleStatus');
        Route::get('/users/{id}', [AdminController::class, 'usersShow'])->name('admin.users.show');

        // Quản lý nhà cung cấp (Đầy đủ chức năng)
        Route::get('/suppliers', [AdminController::class, 'suppliersIndex'])->name('admin.suppliers.index');
        Route::get('/suppliers/create', [AdminController::class, 'suppliersCreate'])->name('admin.suppliers.create');
        Route::post('/suppliers/store', [AdminController::class, 'suppliersStore'])->name('admin.suppliers.store');
        Route::get('/suppliers/{id}/edit', [AdminController::class, 'suppliersEdit'])->name('admin.suppliers.edit');
        Route::put('/suppliers/{id}', [AdminController::class, 'suppliersUpdate'])->name('admin.suppliers.update');
        Route::delete('/suppliers/{id}', [AdminController::class, 'suppliersDestroy'])->name('admin.suppliers.destroy');

        // Nghiệp vụ Quản lý đánh giá sách
        Route::get('/reviews', [AdminController::class, 'reviewsIndex'])->name('admin.reviews.index');
        Route::post('/reviews/{id}/approve', [AdminController::class, 'reviewsApprove'])->name('admin.reviews.approve');
        Route::post('/reviews/{id}/reply', [AdminController::class, 'reviewsReply'])->name('admin.reviews.reply');
        Route::post('/reviews/{id}/violate', [AdminController::class, 'reviewsViolate'])->name('admin.reviews.violate');
        Route::delete('/reviews/{id}', [AdminController::class, 'reviewsDestroy'])->name('admin.reviews.destroy');

    });
});