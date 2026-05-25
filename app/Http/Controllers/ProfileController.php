<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\User; // THÊM DÒNG NÀY: Gọi Model User để fix triệt để lỗi Intelephense

class ProfileController extends Controller
{
    // 1. Hiển thị thông tin cá nhân kèm lịch sử đơn hàng đã đặt
    public function index()
    {
        $user = Auth::user();
        
        // Lấy toàn bộ đơn hàng của user này từ mới đến cũ
        $orders = Order::where('user_id', $user->id)->latest()->get();

        return view('profile', compact('user', 'orders'));
    }

    // 2. Xử lý cập nhật thông tin cơ bản (Họ tên, Email)
    public function update(Request $request)
    {
        // FIX TẠI ĐÂY: Dùng User::findOrFail để IDE nhận diện rõ ràng hàm update()
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Bạn không được để trống họ tên nhé.',
            'email.required' => 'Vui lòng điền địa chỉ Email đầy đủ.',
            'email.unique' => 'Email này đã có người khác sử dụng rồi bạn ơi.'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', '🎉 Cập nhật thông tin cá nhân thành công rồi nhé!');
    }

    // 3. Xử lý đổi mật khẩu an toàn
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng điền mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải dài từ 8 ký tự trở lên nha bạn.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới nhập lại chưa khớp kìa bạn.'
        ]);

        // FIX TẠI ĐÂY: Dùng User::findOrFail để xóa bỏ lỗi gạch đỏ linter
        $user = User::findOrFail(Auth::id());

        // Kiểm tra xem mật khẩu hiện tại gõ vào có khớp với DB không
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác, thử lại nhé bạn!');
        }

        // Cập nhật mật khẩu mới đã được mã hóa Hash
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', '🔒 Đổi mật khẩu mới thành công và bảo mật rồi nhé!');
    }
}