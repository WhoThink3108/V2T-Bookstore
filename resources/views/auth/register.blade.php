@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - V2T Bookstore')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="bg-white p-10 rounded-lg shadow-sm w-full max-w-md border border-gray-100 my-10">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold font-serif text-[var(--color-v2t-text)] mb-2">V2T Bookstore</h1>
            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Thiên Đường Sách Hiện Đại</p>
        </div>

        <div class="flex justify-center border-b border-gray-200 mb-6">
            <a href="/login" class="pb-2 px-4 text-gray-400 hover:text-[var(--color-v2t-text)] font-medium text-sm transition">Đăng nhập</a>
            <a href="/register" class="pb-2 px-4 border-b-2 border-[var(--color-v2t-green)] font-medium text-[var(--color-v2t-green)] text-sm">Đăng ký</a>
        </div>

        <h2 class="text-xl font-serif font-bold mb-1">Tạo tài khoản mới</h2>
        <p class="text-xs text-gray-500 mb-6">Tham gia cộng đồng yêu sách của chúng tôi ngay hôm nay.</p>

        <form action="/register" method="POST">
            @csrf
            @if ($errors->any())
                <div style="background: #fee2e2; color: #991b1b; padding: 10px; margin-bottom: 10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Họ và tên</label>
                <input type="text" name="name" placeholder="Nguyễn Văn A" class="w-full px-3 py-2.5 border border-gray-300 rounded focus:outline-none focus:border-[var(--color-v2t-green)] focus:ring-1 focus:ring-[var(--color-v2t-green)] text-sm transition">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Địa chỉ Email</label>
                <input type="email" name="email" placeholder="nguyenvana@email.com" class="w-full px-3 py-2.5 border border-gray-300 rounded focus:outline-none focus:border-[var(--color-v2t-green)] focus:ring-1 focus:ring-[var(--color-v2t-green)] text-sm transition">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-3 py-2.5 border border-gray-300 rounded focus:outline-none focus:border-[var(--color-v2t-green)] focus:ring-1 focus:ring-[var(--color-v2t-green)] text-sm transition">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-3 py-2.5 border border-gray-300 rounded focus:outline-none focus:border-[var(--color-v2t-green)] focus:ring-1 focus:ring-[var(--color-v2t-green)] text-sm transition">
            </div>

            <button type="submit" class="w-full bg-[var(--color-v2t-green)] text-white font-medium py-2.5 rounded hover:bg-[var(--color-v2t-green-hover)] transition duration-200 text-sm">
                Tạo tài khoản
            </button>

            <p class="text-center text-[10px] text-gray-400 mt-6">
                Bằng cách đăng ký, bạn đồng ý với các Điều khoản & Chính sách của V2T Bookstore.
            </p>
        </form>
    </div>
</div>
@endsection