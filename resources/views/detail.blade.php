@extends('layouts.app')

@section('title', $book->title . ' - V2T Bookstore')

@section('content')
<div class="container mx-auto max-w-6xl py-6">
    <nav class="text-sm text-gray-500 mb-8">
        <a href="/" class="hover:text-[var(--color-v2t-green)] transition">Trang chủ</a> 
        <span class="mx-2">/</span>
        <a href="/shop" class="hover:text-[var(--color-v2t-green)] transition">Sách</a> 
        <span class="mx-2">/</span>
        <span class="text-[var(--color-v2t-green)] font-medium">{{ $book->title }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
        <div class="md:col-span-5">
            <div class="sticky top-24">
                <div class="bg-gray-50 p-2 rounded-xl shadow-lg border border-gray-100 overflow-hidden group flex justify-center items-center" style="aspect-ratio: 2 / 3; width: 100%;">
                    <img src="{{ $book->image_url }}" 
                         alt="{{ $book->title }}" 
                         onerror="this.onerror=null; this.src='https://placehold.co/400x600/10b981/ffffff?text=V2T+Bookstore';"
                         class="max-w-full max-h-full object-contain transform group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>

        <div class="md:col-span-7">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-4">{{ $book->title }}</h1>
            <p class="text-xl text-gray-600 mb-6 italic">bởi {{ $book->author }}</p>

            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-baseline gap-3">
                        <span class="text-4xl font-bold text-[var(--color-v2t-green)]">{{ number_format($book->price, 0, ',', '.') }}đ</span>
                        @if($book->reviews_avg_rating)
                            <span class="text-base font-bold text-amber-500">★ {{ number_format($book->reviews_avg_rating, 1) }}</span>
                        @endif
                    </div>
                    
                    <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $book->stock > 0 ? 'Còn hàng (' . $book->stock . ')' : 'Hết hàng' }}
                    </span>
                </div>

                <form action="{{ route('cart.add', $book->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white">
                        <button type="button" onclick="this.parentNode.querySelector('input').stepDown()" class="px-4 py-3 hover:bg-gray-200 transition focus:outline-none font-bold text-gray-600">&minus;</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}" readonly class="w-16 text-center py-3 border-x border-gray-300 focus:outline-none font-bold text-gray-800 bg-transparent">
                        <button type="button" onclick="this.parentNode.querySelector('input').stepUp()" class="px-4 py-3 hover:bg-gray-200 transition focus:outline-none font-bold text-gray-600">&plus;</button>
                    </div>
                    
                    @if($book->stock > 0)
                        <button type="submit" class="flex-1 text-white py-3 rounded-lg hover:opacity-90 transition font-bold shadow-md" style="background-color: #1e3e36;">
                            Thêm vào giỏ hàng
                        </button>
                    @else
                        <button type="button" disabled class="flex-1 bg-gray-300 text-gray-500 py-3 rounded-lg font-bold cursor-not-allowed text-center">
                            Sản phẩm tạm hết hàng
                        </button>
                    @endif
                </form>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="p-4 bg-white border border-gray-100 rounded-lg shadow-sm">
                    <p class="text-gray-400 uppercase text-[10px] font-bold mb-1">Nhà xuất bản</p>
                    <p class="font-medium text-gray-800">{{ $book->publisher ?? 'Inkwell Press' }}</p>
                </div>
                <div class="p-4 bg-white border border-gray-100 rounded-lg shadow-sm">
                    <p class="text-gray-400 uppercase text-[10px] font-bold mb-1">Năm xuất bản</p>
                    <p class="font-medium text-gray-800">{{ $book->publish_year ?? '2023' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-12">
            
            <section class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-4 border-l-4 border-[var(--color-v2t-green)] pl-4">Tóm tắt nội dung</h2>
                <div class="text-gray-600 leading-relaxed bg-white p-6 rounded-lg shadow-sm border border-gray-100 whitespace-pre-line">
                    {{ $book->description ?? 'Đang cập nhật nội dung...' }}
                </div>
            </section>

            <section class="space-y-6">
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-4 border-l-4 border-[var(--color-v2t-green)] pl-4">Đánh giá từ độc giả</h2>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    @auth
                        <form action="{{ route('reviews.store', $book->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <h3 class="text-sm font-bold text-gray-800">Chia sẻ trải nghiệm của bro về cuốn sách này</h3>
                            
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-semibold text-gray-700">Đánh giá:</span>
                                <select name="rating" class="bg-gray-50 border border-gray-300 rounded px-3 py-1.5 text-sm font-bold text-amber-500 focus:outline-none focus:border-emerald-700 cursor-pointer shadow-sm">
                                    <option value="5">★★★★★</option>
                                    <option value="4">★★★★☆</option>
                                    <option value="3">★★★☆☆</option>
                                    <option value="2">★★☆☆☆</option>
                                    <option value="1">★☆☆☆☆</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <textarea name="comment" rows="4" placeholder="Cuốn sách này để lại cho bro ấn tượng gì? Viết vài lời chia sẻ tại đây nhé..." class="w-full p-4 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:outline-none focus:border-emerald-700 focus:bg-white transition leading-relaxed shadow-inner" required></textarea>
                            </div>

                            <button type="submit" class="text-white text-xs font-bold px-5 py-2.5 rounded-lg transition shadow hover:opacity-95" style="background-color: #1e3e36; display: inline-block;">
                                Gửi đánh giá của tôi
                            </button>
                        </form>
                    @else
                        <div class="text-center py-2">
                            <p class="text-sm text-gray-500">Bro cần <a href="/login" class="text-[var(--color-v2t-green)] font-bold hover:underline">Đăng nhập</a> để viết đánh giá cho cuốn sách này.</p>
                        </div>
                    @endauth
                </div>

                <div class="space-y-4 mt-6">
                    @if($book->reviews->count() > 0)
                        @foreach($book->reviews as $review)
                            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex gap-4 items-start">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center font-bold text-[var(--color-v2t-green)] shrink-0">
                                    {{ substr($review->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="space-y-1 w-full">
                                    <div class="flex items-center justify-between gap-4">
                                        <h4 class="text-sm font-bold text-gray-800">{{ $review->user->name ?? 'Người dùng ẩn danh' }}</h4>
                                        <span class="text-[10px] text-gray-400 font-medium">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="text-xs text-amber-500">
                                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed pt-1">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-gray-50/50 p-6 rounded-lg text-center border border-dashed border-gray-200">
                            <p class="text-xs text-gray-400 italic">Chưa có lượt đánh giá nào cho cuốn sách này. Hãy là người đầu tiên chia sẻ cảm nghĩ của mình bro nhé!</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <div class="bg-[var(--color-v2t-green)] p-8 rounded-xl text-white shadow-md">
                <h3 class="text-xl font-serif font-bold mb-4">Ghi chú từ Biên tập viên</h3>
                <p class="text-sm italic opacity-90 leading-relaxed mb-6">"Cuốn sách này là một hành trình trải nghiệm sâu sắc về tư duy, rất đáng có một vị trí trang trọng trên kệ sách của bro."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold">V2T</div>
                    <div class="text-sm font-bold">Ban biên tập <span class="block font-normal opacity-70">V2T Bookstore</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection