@extends('layouts.app')

@section('title', 'Đăng nhập - V2T Bookstore')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="bg-white p-10 rounded-lg shadow-sm w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold font-serif text-v2t-text mb-2">V2T Bookstore</h1>
            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Thiên Đường Sách Hiện Đại</p>
        </div>

        <div class="flex justify-center border-b border-gray-200 mb-6">
            <a href="/login" class="pb-2 px-4 border-b-2 border-v2t-green font-medium text-v2t-green text-sm">Đăng nhập</a>
            <a href="/register" class="pb-2 px-4 text-gray-400 hover:text-v2t-text font-medium text-sm transition">Đăng ký</a>
        </div>
        
        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 0.875rem; margin-bottom: 16px; font-weight: 500;">
                {{ $errors->first() }}
            </div>
        @endif

        <h2 class="text-xl font-serif font-bold mb-1">Chào mừng trở lại</h2>
        <p class="text-xs text-gray-500 mb-6">Vui lòng nhập thông tin tài khoản để tiếp tục.</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Địa chỉ Email</label>
                <input type="email" name="email" placeholder="nguyenvana@email.com" class="w-full px-3 py-2.5 border border-gray-300 rounded focus:outline-none focus:border-v2t-green focus:ring-2 focus:ring-v2t-green text-sm" required>
            </div>

            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-semibold text-gray-700">Mật khẩu</label>
                    <a href="#" class="text-xs text-gray-500 hover:text-v2t-green hover:underline">Quên mật khẩu?</a>
                </div>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-3 py-2.5 border border-gray-300 rounded focus:outline-none focus:border-v2t-green focus:ring-2 focus:ring-v2t-green text-sm" required>
            </div>

            <div style="margin-top: 16px; display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="remember" id="remember" style="cursor: pointer;">
                <label App\for="remember" style="font-size: 0.875rem; color: #4b5563; cursor: pointer;">Lưu tài khoản đăng nhập</label>
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" 
                        style="width: 100%; padding: 12px; background-color: #1e3e36; color: white; border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='#142b25'" 
                        onmouseout="this.style.backgroundColor='#1e3e36'">
                    Đăng nhập
                </button>
            </div>

            <button type="submit" class="w-full bg-v2t-green text-white font-medium py-2.5 rounded hover:bg-v2t-green-hover transition duration-200 text-sm">
                Đăng nhập
            </button>
        </form>
    </div>
</div>
@endsection