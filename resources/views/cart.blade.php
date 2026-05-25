@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn - V2T Bookstore')

@section('content')
<div class="bg-[#f8f7f4] -mx-4 px-4 py-10 min-h-screen" style="background-color: #f8f7f4; min-height: 100vh;">
    <div class="container mx-auto max-w-6xl">
        
        <div class="mb-6">
            <p class="text-xs text-gray-400 mb-1">Trang chủ / <span class="text-gray-600 font-medium">Giỏ hàng của bạn</span></p>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Giỏ hàng</h1>
        </div>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start" style="display: grid; gap: 32px;">
                
                <div class="lg:col-span-2 space-y-4" style="grid-column: span 2 / span 2;">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm" style="display: flex; background: white; padding: 24px; border-radius: 12px; border: 1px solid #f3f4f6; gap: 24px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                            
                            <div style="width: 96px; height: 135px; min-width: 96px; flex-shrink: 0; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>

                            <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 135px;">
                                
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;">
                                    <div>
                                        <h3 class="font-serif font-bold text-xl text-gray-900 leading-tight" style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #111827;">{{ $item['title'] }}</h3>
                                        <p class="text-xs text-gray-400 font-medium" style="margin-top: 4px; color: #9ca3af; font-size: 0.75rem;">{{ $item['author'] ?? 'Chưa cập nhật tác giả' }}</p>
                                        <span class="inline-block text-[10px] px-2.5 py-0.5 rounded bg-orange-50 text-orange-700 font-bold tracking-wide" style="margin-top: 8px; display: inline-block; background-color: #fff7ed; color: #c2410c; padding: 2px 10px; border-radius: 4px; font-size: 10px; font-weight: 700;">Tiểu Thuyết</span>
                                    </div>
                                    <span class="font-serif font-bold text-lg text-gray-900" style="font-size: 1.125rem; font-weight: 700; color: #111827; white-space: nowrap;">
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px;">
                                    
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white h-9 shadow-sm">
                                        @csrf
                                        <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.submit();" class="w-9 h-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-500 font-medium text-base transition focus:outline-none" style="width: 36px; border: none; cursor: pointer;">&minus;</button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" readonly class="w-12 text-center bg-transparent text-sm font-bold text-gray-800 focus:outline-none" style="width: 48px; text-align: center; border: none; font-weight: 700;">
                                        <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.submit();" class="w-9 h-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-500 font-medium text-base transition focus:outline-none" style="width: 36px; border: none; cursor: pointer;">&plus;</button>
                                    </form>

                                    <form action="{{ route('cart.remove', $id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1 transition px-3 py-1.5 rounded-md hover:bg-red-50" style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.75rem; font-weight: 600;">
                                            🗑️ Xóa
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center pt-2 text-sm">
                        <a href="/" class="text-gray-500 hover:text-gray-800 font-medium flex items-center gap-1 transition">
                            &larr; Tiếp tục mua sắm
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition font-medium">
                                Làm trống giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:sticky lg:top-24" style="grid-column: span 1 / span 1;">
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm" style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #f3f4f6;">
                        <h2 class="text-lg font-serif font-bold text-gray-800 mb-5" style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin-bottom: 20px;">Tóm tắt đơn hàng</h2>
                        
                        <div class="text-sm space-y-3.5 pb-4 text-gray-500" style="font-size: 0.875rem; color: #6b7280; border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                            <div class="flex justify-between" style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span>Tạm tính ({{ count($cart) }} sản phẩm)</span>
                                <span class="font-medium text-gray-900" style="color: #111827; font-weight: 500;">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex justify-between" style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span>Phí vận chuyển (Dự tính)</span>
                                <span class="font-medium text-gray-900" style="color: #111827; font-weight: 500;">30.000đ</span>
                            </div>
                            <div class="flex justify-between text-emerald-600" style="display: flex; justify-content: space-between; color: #059669;">
                                <span>Giảm giá</span>
                                <span class="font-medium">-0đ</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center my-5" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; margin-bottom: 20px;">
                            <span class="text-base font-bold text-gray-800" style="font-size: 1rem; font-weight: 700; color: #1f2937;">Tổng cộng</span>
                            <span class="text-2xl font-serif font-bold text-v2t-green" style="font-size: 1.5rem; font-weight: 700; color: var(--color-v2t-green);">
                                {{ number_format($total + 30000, 0, ',', '.') }}đ
                            </span>
                        </div>

                        <div class="mb-6" style="margin-bottom: 24px;">
                            <label class="block text-xs font-semibold text-gray-400 mb-1.5" style="display: block; font-size: 0.75rem; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">Mã giảm giá</label>
                            <div class="flex gap-2" style="display: flex; gap: 8px;">
                                <input type="text" placeholder="Nhập mã của bạn" class="flex-grow px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[var(--color-v2t-green)] transition" style="flex-grow: 1; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                                <button type="button" class="bg-[#8b5a2b] hover:opacity-90 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shrink-0" style="background-color: #8b5a2b; color: white; padding: 8px 16px; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: 600; cursor: pointer;">Áp dụng</button>
                            </div>
                        </div>

                        <a href="{{ route('cart.checkout') }}" class="w-full bg-[var(--color-v2t-green)] hover:opacity-95 text-white font-serif font-bold py-3.5 rounded-lg transition flex items-center justify-center gap-2 shadow-md tracking-wide text-center" style="display: block; width: 100%; background-color: var(--color-v2t-green); color: white; padding: 14px 0; border-radius: 8px; font-weight: 700; text-align: center; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                            Thanh toán ngay 💳
                        </a>

                        <div class="mt-6 pt-5 space-y-2.5 text-xs text-gray-500" style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f9fafb; font-size: 0.75rem; color: #6b7280;">
                            <p style="margin: 0 0 10px 0;">🛡️ <span class="font-medium" style="margin-left: 4px;">Thanh toán bảo mật 100%</span></p>
                            <p style="margin: 0 0 10px 0;">🚚 <span class="font-medium" style="margin-left: 4px;">Miễn phí giao hàng cho đơn từ 500k</span></p>
                            <p style="margin: 0;">🔄 <span class="font-medium" style="margin-left: 4px;">Đổi trả trong vòng 14 ngày</span></p>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl border border-gray-100 shadow-sm max-w-md mx-auto mt-12" style="text-align: center; padding: 80px 0; background: white; border-radius: 12px; border: 1px solid #f3f4f6; max-width: 28rem; margin: 48px auto 0 auto;">
                <p style="font-size: 3rem; margin: 0 0 16px 0;">🛒</p>
                <p class="text-gray-600 font-medium mb-6" style="color: #4b5563; font-weight: 500; margin-bottom: 24px;">Giỏ hàng của bạn đang trống trơn!</p>
                <a href="/" class="bg-[var(--color-v2t-green)] text-white px-6 py-2.5 rounded-lg font-medium hover:opacity-90 transition inline-block" style="background-color: var(--color-v2t-green); color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-block;">Quay lại mua sách ngay</a>
            </div>
        @endif
    </div>
</div>
@endsection