<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Sử dụng Database Transaction
use App\Models\Book;
use App\Models\Order;       // Gọi Model Order
use App\Models\OrderItem;   // Gọi Model OrderItem
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Hiển thị trang giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // 2. Thêm sách vào giỏ hàng
    public function add(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);
        
        // Lấy số lượng từ form gửi lên, nếu không có thì mặc định là 1
        $quantityToAdd = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            // Cộng dồn số lượng mới vào số lượng cũ đã có trong giỏ
            $cart[$id]['quantity'] += $quantityToAdd;
        } else {
            $cart[$id] = [
                "title" => $book->title,
                "quantity" => $quantityToAdd, // Lưu số lượng thực tế
                "price" => $book->price,
                "image_url" => $book->image_url ?? 'default-book.jpg',
                "author" => $book->author
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sách vào giỏ hàng!');
    }

    // 3. Cập nhật số lượng sách trong giỏ hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Đã cập nhật số lượng giỏ hàng!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    // 4. Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    // 5. Hiển thị trang thanh toán độc lập
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        return view('checkout', compact('cart'));
    }

    // 6. Làm trống toàn bộ giỏ hàng
    public function clear()
    {
        session()->forget('cart'); // Xóa toàn bộ key 'cart' trong session
        return redirect()->back()->with('success', 'Đã làm trống giỏ hàng!');
    }
    
    // 7. Xử lý đặt hàng thực tế, lưu vào Database và TRỪ KHO
    public function placeOrder(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào từ form checkout gửi lên
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // 2. Tính toán tổng tiền (Tổng tiền sách - giảm giá + 30.000đ ship cố định)
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            if ($coupon['code'] === 'V2T10') {
                $discount = $subtotal * 0.1;
            } elseif ($coupon['code'] === 'GIAM50' && $subtotal >= 200000) {
                $discount = 50000;
            }
        }

        $totalAmount = $subtotal + 30000 - $discount;
        if ($totalAmount < 0) {
            $totalAmount = 0;
        }

        // 3. Mở Transaction bảo vệ DB
        DB::beginTransaction();

        try {
            // Ghép "Địa chỉ chi tiết" và "Thành phố" thành một chuỗi duy nhất để lưu vào cột shipping_address
            $fullShippingAddress = $request->address . ', ' . $request->city;

            // Lưu thông tin vào bảng `orders` chuẩn theo các cột 
            $order = Order::create([
                'user_id'          => Auth::id(), // Đã đồng bộ Auth Facade chuẩn chỉnh
                'total_price'      => $totalAmount, // Khớp với cột total_price
                'status'           => 'pending',
                'phone'            => $request->phone, // Khớp với cột phone
                'shipping_address' => $fullShippingAddress, // Khớp với cột shipping_address
                'payment_method'   => $request->payment_method,
            ]);

            // Vòng lặp lưu vào bảng chi tiết `order_items` và xử lý TRỪ TỒN KHO
            foreach ($cart as $bookId => $item) {
                // Tìm cuốn sách đang được mua để kiểm tra số lượng kho
                $book = Book::findOrFail($bookId);

                // KIỂM TRA: Nếu số lượng đặt mua lớn hơn số lượng tồn kho trong DB
                if ($book->stock < $item['quantity']) {
                    // Hoàn tác lại toàn bộ Transaction (không sinh đơn hàng rác)
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', 'Sách "' . $book->title . '" hiện tại không đủ số lượng tồn kho!');
                }

                // Lưu dữ liệu vào bảng chi tiết đơn hàng
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id'  => $bookId,
                    'quantity' => $item['quantity'],
                    'price'    => $item['price'],
                ]);

                // THAY ĐỔI TẠI ĐÂY: Trừ số lượng tồn kho tương ứng của cuốn sách đó
                $book->decrement('stock', $item['quantity']);
            }

            // Chốt đơn thành công, lưu chính thức mọi thay đổi vào DB
            DB::commit();

            // Xóa sạch giỏ hàng và coupon trong session
            session()->forget('cart');
            session()->forget('coupon');

            return redirect('/')->with('success', '🎉 Đặt đơn hàng thành công! Đơn hàng #' . $order->id . ' của bạn đã được ghi nhận.');

        } catch (\Exception $e) {
            // Hoàn tác hệ thống nếu phát sinh lỗi bất ngờ
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Có lỗi hệ thống xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    // 8. Áp dụng mã giảm giá
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = strtoupper($request->coupon_code);
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($code === 'V2T10') {
            $discount = $subtotal * 0.1;
            session()->put('coupon', [
                'code' => 'V2T10',
                'type' => 'percentage',
                'value' => 10,
                'discount' => $discount,
            ]);
            return redirect()->back()->with('success', '🎉 Đã áp dụng mã giảm giá V2T10 (Giảm 10%)!');
        } elseif ($code === 'GIAM50') {
            if ($subtotal < 200000) {
                return redirect()->back()->with('error', 'Mã GIAM50 chỉ áp dụng cho đơn hàng từ 200.000đ trở lên!');
            }
            $discount = 50000;
            session()->put('coupon', [
                'code' => 'GIAM50',
                'type' => 'fixed',
                'value' => 50000,
                'discount' => $discount,
            ]);
            return redirect()->back()->with('success', '🎉 Đã áp dụng mã giảm giá GIAM50 (Giảm 50k)!');
        }

        return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ!');
    }

    // 9. Hủy mã giảm giá
    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Đã hủy áp dụng mã giảm giá.');
    }
}