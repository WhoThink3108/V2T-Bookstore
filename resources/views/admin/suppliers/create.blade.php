@extends('layouts.admin')

@section('title', 'Thêm nhà cung cấp mới')

@section('content')
<div style="width: 100%; max-width: 650px; margin: 0 auto;">
    <a href="{{ route('admin.suppliers.index') }}" style="text-decoration: none; color: #1e3e36; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; font-size: 0.9rem;">
        ← Quay lại danh mục
    </a>

    <div style="background: white; padding: 32px; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.01);">
        <h2 style="font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 1.4rem; font-weight: 700; color: #1e3e36; margin: 0 0 24px 0;">Thêm đối tác cung ứng mới</h2>

        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Tên nhà cung cấp</label>
                    <input type="text" name="name" placeholder="Ví dụ: Nhà xuất bản Trẻ" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Mã hợp đồng</label>
                    <input type="text" name="contract_code" placeholder="Ví dụ: #TR-2023-01" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Người đại diện liên hệ</label>
                    <input type="text" name="contact_name" placeholder="Nguyễn Văn A" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Chức vụ</label>
                    <input type="text" name="contact_title" placeholder="Giám đốc kinh doanh" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Số điện thoại</label>
                    <input type="text" name="phone" placeholder="090 123 4567" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Hòm thư Email</label>
                    <input type="email" name="email" placeholder="doi_tac@domain.com" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;" required>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #4b5563; margin-bottom: 6px;">Trạng thái hợp tác ban đầu</label>
                <select name="status" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                    <option value="active">Đang hoạt động bình thường</option>
                    <option value="paused">Tạm dừng hợp tác</option>
                </select>
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: #1e3e36; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem;">
                Xác nhận thêm nhà cung cấp
            </button>
        </form>
    </div>
</div>
@endsection