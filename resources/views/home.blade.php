@extends('layouts.app')

@section('title', 'V2T Bookstore - Thiên Đường Sách Hiện Đại')

@section('content')
<div class="relative bg-[var(--color-v2t-green)] rounded-xl overflow-hidden mb-12 shadow-lg">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80" alt="Thư viện" class="w-full h-full object-cover">
    </div>
    
    <div class="relative p-10 md:p-16 flex flex-col md:flex-row items-center justify-between">
        <div class="max-w-2xl text-white">
            <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-xs font-bold tracking-wider mb-4 uppercase">Sách Mới Phát Hành</span>
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4 leading-tight">Khám Phá Những Lời Thì Thầm Của Lịch Sử</h1>
            <p class="text-sm md:text-base text-gray-200 mb-8 line-clamp-3">
                Đắm chìm trong bộ sưu tập sách mùa đông được tuyển chọn kỹ lưỡng của chúng tôi. Mỗi trang sách chứa đựng một hành trình mới, mỗi gáy sách kể một câu chuyện về sự tinh hoa.
            </p>
            <div class="flex gap-4">
                <a href="/shop" class="bg-white text-[var(--color-v2t-green)] font-semibold py-2.5 px-6 rounded hover:bg-gray-100 transition">Mua Ngay</a>
                <a href="#" class="border border-white text-white font-semibold py-2.5 px-6 rounded hover:bg-white/20 transition">Câu Chuyện Của Chúng Tôi</a>
            </div>
        </div>
    </div>
</div>

<div class="mb-12">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-serif font-bold text-[var(--color-v2t-text)]">Sách Bán Chạy Nhất</h2>
            <p class="text-sm text-gray-500 mt-1">Những cuốn sách mọi người đang bàn tán tuần này.</p>
        </div>
        <a href="/shop" class="text-sm font-medium text-[var(--color-v2t-green)] hover:underline">Xem tất cả &rarr;</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($books as $book)
            <div class="group flex flex-col bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                
                <a href="{{ route('book.show', $book->id) }}" class="relative h-64 mb-4 overflow-hidden rounded bg-gray-50 block">
                    <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
                </a>
                
                <div class="flex items-center justify-between gap-2 mb-2 text-[10px] font-bold tracking-wider uppercase">
                    @if($book->stock > 15)
                        <span style="color: #b45309;">BÁN CHẠY</span>
                    @else
                        <span style="color: #047857;">SÁCH MỚI</span>
                    @endif

                    @if($book->reviews_avg_rating)
                        <span class="text-amber-500 flex items-center gap-0.5" style="color: #f59e0b; font-size: 11px;">★ {{ number_format($book->reviews_avg_rating, 1) }}</span>
                    @else
                        <span style="color: #9ca3af; font-size: 9px; text-transform: none; font-weight: 500; font-family: sans-serif;">Chưa có đánh giá</span>
                    @endif
                </div>
                
                <h3 class="font-serif font-bold text-lg text-gray-900 leading-tight mb-1 hover:text-[var(--color-v2t-green)] transition">
                    <a href="{{ route('book.show', $book->id) }}">{{ $book->title }}</a>
                </h3>
                
                <p class="text-sm text-gray-600 italic mb-4">bởi {{ $book->author }}</p>
                
                <div class="mt-auto flex items-center justify-between">
                    <span class="font-bold text-[var(--color-v2t-green)]">{{ number_format($book->price, 0, ',', '.') }}đ</span>
                    
                    <form action="{{ route('cart.add', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[var(--color-v2t-bg)] text-[var(--color-v2t-green)] border border-[var(--color-v2t-green)] hover:bg-[var(--color-v2t-green)] hover:text-white text-xs px-4 py-2 rounded transition font-medium">
                            Thêm
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection