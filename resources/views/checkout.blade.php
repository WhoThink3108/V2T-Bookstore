@extends('layouts.app')

@section('title', 'Thông tin thanh toán - V2T Bookstore')

@section('content')
<div class="bg-[#f8f7f4] -mx-4 px-4 py-10 min-h-screen" style="background-color: #f8f7f4; min-height: 100vh;">
    <div class="container mx-auto max-w-6xl">
        
        @if(session('error'))
            <div style="background-color: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <strong>⚠️ Lỗi hệ thống:</strong> {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <strong>⚠️ Vui lòng kiểm tra lại form:</strong>
                <ul style="list-style-type: disc; padding-left: 20px; margin-top: 8px; font-size: 0.875rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p class="text-xs text-gray-400 mb-6">Giỏ hàng &rsaquo; <span class="text-gray-700 font-medium">Thanh toán</span></p>

        <form action="{{ route('cart.placeOrder') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start" style="display: grid; gap: 32px;">
                
                <div class="lg:col-span-2 space-y-6" style="grid-column: span 2 / span 2; display: flex; flex-direction: column; gap: 24px;">
                    
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm" style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #f3f4f6;">
                        <div class="flex items-center gap-2 mb-6 text-gray-800" style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
                            <span class="text-xl">🚚</span>
                            <h2 class="text-xl font-serif font-bold" style="font-size: 1.25rem; font-weight: 700; margin: 0;">Thông tin giao hàng</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5" style="display: grid; grid-template-cols: repeat(2, minmax(0, 1fr)); gap: 20px;">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5" style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; margin-bottom: 6px;">Họ và tên</label>
                                <input type="text" name="name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Nhập họ tên người nhận" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-[var(--color-v2t-green)] transition shadow-sm" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5" style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; margin-bottom: 6px;">Email</label>
                                <input type="email" name="email" required value="{{ auth()->user()->email ?? '' }}" placeholder="name@example.com" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-[var(--color-v2t-green)] transition shadow-sm" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                            </div>
                            <div class="col-span-2" style="grid-column: span 2 / span 2;">
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5" style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; margin-bottom: 6px;">Địa chỉ chi tiết</label>
                                <input type="text" name="address" required placeholder="Số nhà, tên đường, phường/xã..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-[var(--color-v2t-green)] transition shadow-sm" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5" style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; margin-bottom: 6px;">Thành phố / Tỉnh</label>
                                <input type="text" name="city" required placeholder="Ví dụ: TP. Hồ Chí Minh" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-[var(--color-v2t-green)] transition shadow-sm" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5" style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; margin-bottom: 6px;">Số điện thoại</label>
                                <input type="text" name="phone" required placeholder="Ví dụ: 0901 234 567" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-[var(--color-v2t-green)] transition shadow-sm" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm" style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #f3f4f6;">
                        <div class="flex items-center gap-2 mb-6 text-gray-800" style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
                            <span class="text-xl">💳</span>
                            <h2 class="text-xl font-serif font-bold" style="font-size: 1.25rem; font-weight: 700; margin: 0;">Phương thức thanh toán</h2>
                        </div>
                        
                        <div class="space-y-3" style="display: flex; flex-direction: column; gap: 12px;">
                            <label class="payment-method-card flex items-center justify-between p-4 border rounded-xl cursor-pointer transition" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border-radius: 12px; border: 2px solid var(--color-v2t-green); background-color: rgba(16, 185, 129, 0.05); cursor: pointer;">
                                <div class="flex items-center gap-3.5" style="display: flex; align-items: center; gap: 14px;">
                                    <span class="text-xl">💳</span>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900" style="margin: 0; font-size: 0.875rem; font-weight: 700; color: #111827;">Thẻ tín dụng / Ghi nợ</p>
                                        <p class="text-[11px] text-gray-400" style="margin: 0; font-size: 11px; color: #9ca3af;">Visa, Mastercard, JCB</p>
                                    </div>
                                </div>
                                <input type="radio" name="payment_method" value="credit" checked class="w-4 h-4 text-[var(--color-v2t-green)] focus:ring-[var(--color-v2t-green)]" style="cursor: pointer;">
                            </label>

                            <label class="payment-method-card flex items-center justify-between p-4 border rounded-xl cursor-pointer transition" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; background-color: #ffffff; cursor: pointer;">
                                <div class="flex items-center gap-3.5" style="display: flex; align-items: center; gap: 14px;">
                                    <span class="text-xl">💵</span>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900" style="margin: 0; font-size: 0.875rem; font-weight: 700; color: #111827;">Thanh toán khi nhận hàng (COD)</p>
                                        <p class="text-[11px] text-gray-400" style="margin: 0; font-size: 11px; color: #9ca3af;">Trả tiền mặt khi shipper giao tới</p>
                                    </div>
                                </div>
                                <input type="radio" name="payment_method" value="cod" class="w-4 h-4 text-[var(--color-v2t-green)] focus:ring-[var(--color-v2t-green)]" style="cursor: pointer;">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="lg:sticky lg:top-24" style="grid-column: span 1 / span 1;">
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm" style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #f3f4f6;">
                        <h2 class="text-lg font-serif font-bold text-gray-800 mb-4" style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">Tóm tắt đơn hàng</h2>
                        
                        <div class="max-h-48 overflow-y-auto divide-y divide-gray-50 pr-1 mb-5" style="max-height: 12rem; overflow-y: auto; margin-bottom: 20px;">
                            @php $total = 0; @endphp
                            @foreach($cart as $id => $item)
                                @php $total += $item['price'] * $item['quantity']; @endphp
                                <div class="flex items-center gap-3 py-3" style="display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f9fafb;">
                                    <div class="w-10 h-14 bg-gray-50 border border-gray-100 rounded overflow-hidden shrink-0" style="width: 40px; height: 56px; flex-shrink: 0; border-radius: 4px; overflow: hidden; border: 1px solid #e5e7eb;">
                                        <img src="{{ $item['image_url'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow min-w-0" style="flex-grow: 1; min-w: 0;">
                                        <h4 class="text-xs font-bold text-gray-900 truncate" style="margin: 0; font-size: 0.75rem; font-weight: 700; color: #111827; overflow: text-overflow; white-space: nowrap; text-overflow: ellipsis;">{{ $item['title'] }}</h4>
                                        <p class="text-[10px] text-gray-400 font-medium mt-0.5" style="margin: 2px 0 0 0; font-size: 10px; color: #9ca3af;">SL: {{ $item['quantity'] }}</p>
                                    </div>
                                    <span class="text-xs font-bold text-gray-700 shrink-0" style="font-size: 0.75rem; font-weight: 700; color: #374151; flex-shrink: 0;">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-sm space-y-3.5 border-t border-b border-gray-100 py-4 text-gray-500" style="font-size: 0.875rem; color: #6b7280; border-top: 1px solid #f3f4f6; border-b: 1px solid #f3f4f6; padding: 16px 0;">
                            <div class="flex justify-between" style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span>Tạm tính</span>
                                <span class="font-medium text-gray-900" style="color: #111827;">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex justify-between" style="display: flex; justify-content: space-between;">
                                <span>Phí vận chuyển</span>
                                <span class="font-medium text-gray-900" style="color: #111827;">30.000đ</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center my-5" style="display: flex; justify-content: space-between; align-items: center; margin: 20px 0;">
                            <span class="text-base font-bold text-gray-800" style="font-size: 1rem; font-weight: 700;">Tổng cộng</span>
                            <span class="text-2xl font-serif font-bold text-[var(--color-v2t-green)]" style="font-size: 1.5rem; font-weight: 700; color: var(--color-v2t-green);">
                                {{ number_format($total + 30000, 0, ',', '.') }}đ
                            </span>
                        </div>

                        <button type="submit" class="w-full bg-[var(--color-v2t-green)] hover:opacity-95 text-white font-serif font-bold py-3.5 rounded-lg transition shadow-md tracking-wide mb-3" style="display: block; width: 100%; background-color: var(--color-v2t-green); color: white; padding: 14px 0; border: none; border-radius: 8px; font-weight: 700; font-size: 1.125rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                            Hoàn tất đặt hàng
                        </button>
                        
                        <p class="text-[10px] text-gray-400 text-center leading-relaxed" style="font-size: 10px; color: #9ca3af; text-align: center; margin: 12px 0 0 0;">
                            Bằng cách đặt hàng, bạn đồng ý với các Điều khoản của V2T Bookstore.
                        </p>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Duyệt xóa sạch màu viền kích hoạt của cả 2 khung
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.style.border = "1px solid #e5e7eb";
                card.style.backgroundColor = "#ffffff";
            });
            
            // Tìm đúng khung bọc ngoài của nút đang click để bật viền xanh lục bảo
            if (this.checked) {
                const activeCard = this.closest('.payment-method-card');
                activeCard.style.border = "2px solid var(--color-v2t-green)";
                activeCard.style.backgroundColor = "rgba(16, 185, 129, 0.05)";
            }
        });
    });
</script>
@endsection