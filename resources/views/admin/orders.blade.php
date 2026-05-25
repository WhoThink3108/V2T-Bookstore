@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<style>
    .stat-card { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .v2t-table { width: 100%; border-collapse: collapse; text-align: left; background: white; border-radius: 12px; }
    .v2t-table th { padding: 16px; color: #6b7280; font-size: 0.85rem; border-bottom: 1px solid #f3f4f6; }
    .v2t-table td { padding: 16px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    
    /* Dùng CSS Variables để tránh lỗi linter */
    .status-badge { 
        padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; 
        background-color: var(--bg-color); color: var(--text-color);
    }
    .status-select { padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: #f9fafb; cursor: pointer; }
</style>

<div style="width: 100%;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Đơn hàng</h1>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">TỔNG ĐƠN HÀNG</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0;">{{ $totalOrders }}</h3>
        </div>
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">ĐANG CHỜ</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0; color: #991b1b;">{{ $pendingOrders }}</h3>
        </div>
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">ĐANG GIAO</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0; color: #92400e;">{{ $shippingOrders }}</h3>
        </div>
        <div class="stat-card">
            <p style="font-size: 0.7rem; color: #6b7280; font-weight: 700; margin-bottom: 5px;">ĐÃ GIAO</p>
            <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0; color: #065f46;">{{ $completedOrders }}</h3>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <table class="v2t-table">
            <thead>
                <tr>
                    <th>MÃ ĐƠN HÀNG</th>
                    <th>KHÁCH HÀNG</th>
                    <th>NGÀY ĐẶT</th>
                    <th>TỔNG CỘNG</th>
                    <th>TRẠNG THÁI</th>
                    <th style="text-align: center;">THAO TÁC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td style="font-weight: 600;">#INK-{{ $order->id }}</td>
                    <td>
                        <div style="font-weight: 600;">{{ $order->user->name }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $order->user->email }}</div>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="status-badge" style="background-color: #fee2e2; color: #991b1b;">
                                {{ ucfirst($order->status) }}
                            </span>
                        @elseif($order->status == 'shipping')
                            <span class="status-badge" style="background-color: #fef3c7; color: #92400e;">
                                {{ ucfirst($order->status) }}
                            </span>
                        @else
                            <span class="status-badge" style="background-color: #d1fae5; color: #065f46;">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            <select name="status" class="status-select" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã giao</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px;">{{ $orders->links() }}</div>
    </div>
</div>
@endsection