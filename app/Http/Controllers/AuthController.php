<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <--- THÊM DÒNG NÀY VÀO

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    // Xử lý đăng nhập hệ thống
    public function login(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Kiểm tra xem tài khoản có tồn tại và có bị khóa hay không
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'blocked') {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn hiện đang bị khóa. Vui lòng liên hệ Admin để được hỗ trợ!',
            ])->withInput();
        }

        // 3. Nếu không bị khóa, tiến hành kiểm tra đăng nhập bình thường
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            // Kiểm tra quyền để chuyển hướng vào Portal Quản trị hoặc Trang chủ
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect('/home');
        }

        // 4. Trả về lỗi nếu sai email hoặc mật khẩu
        return back()->withErrors([
            'email' => 'Thông tin tài khoản hoặc mật khẩu không chính xác.',
        ])->withInput();
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        return redirect('/')->with('success', 'Chào mừng bạn đến với V2T Bookstore!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Bạn đã đăng xuất.');
    }
}