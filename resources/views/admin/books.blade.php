@extends('layouts.admin')

@section('title', 'Quản lý kho sách')

@section('content')
<style>
    .stat-card { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .v2t-book-table { width: 100%; border-collapse: collapse; text-align: left; background-color: #ffffff; }
    .v2t-book-table th { padding: 16px; color: #6b7280; font-size: 0.85rem; border-bottom: 1px solid #f3f4f6; }
    .v2t-book-table td { padding: 16px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .progress-track { width: 120px; height: 8px; background-color: #f3f4f6; border-radius: 4px; overflow: hidden; margin-top: 5px; }
    .progress-fill { height: 100%; border-radius: 4px; }
</style>

<div style="width: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Quản lý kho sách</h1>
        <a href="{{ route('admin.books.create') }}" 
           style="background: #1e3e36; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
           + Thêm sách mới
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">TỔNG ĐẦU SÁCH</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0;">{{ $books->total() }}</h3>
        </div>
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">SẢN PHẨM TRONG KHO</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0;">{{ $books->sum('stock') }}</h3>
        </div>
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">CẢNH BÁO KHO THẤP</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0; color: #dc2626;">{{ $books->where('stock', '<', 10)->count() }}</h3>
        </div>
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">DOANH THU THÁNG</p>
            <h3 class="text-xl font-bold mt-1">
                {{ number_format($monthlyRevenue, 0, ',', '.') }}đ
            </h3>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <table class="v2t-book-table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Tác giả</th>
                    <th>Tồn kho</th>
                    <th>Giá</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $book->image_url }}" style="width: 40px; height: 50px; object-fit: cover; border-radius: 4px;">
                        <span style="font-weight: 600;">{{ $book->title }}</span>
                    </td>
                    <td>{{ $book->author }}</td>
                    <td>
                        <div class="progress-track" style="--progress-width: {{ min(($book->stock/100)*100, 100) }}%; --progress-color: {{ $book->stock < 10 ? '#ef4444' : '#1e3e36' }};">
                            <div class="progress-fill" style="width: var(--progress-width); background-color: var(--progress-color);"></div>
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">{{ $book->stock }} trong kho</div>
                    </td>
                    <td style="font-weight: 600;">{{ number_format($book->price, 0, ',', '.') }}đ</td>
                    <td style="text-align: right; white-space: nowrap;">
                        <a href="{{ route('admin.books.edit', $book->id) }}" style="color: #059669; font-weight: 600; text-decoration: none; margin-right: 15px;">Sửa</a>
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="color: #dc2626; border:none; background:none; font-weight: 600; cursor:pointer;">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px;">{{ $books->links() }}</div>
    </div>
</div>
@endsection