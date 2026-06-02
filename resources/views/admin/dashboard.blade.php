@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .stat-card { background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; }
    .chart-container { background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; }
    .recent-orders-table { width: 100%; border-collapse: collapse; text-align: left; }
    .recent-orders-table th { padding: 12px 0; color: #6b7280; font-size: 0.8rem; border-bottom: 1px solid #f3f4f6; }
    .recent-orders-table td { padding: 16px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; vertical-align: middle; }
    
    /* Thiết lập class riêng cho Badge Trạng thái - Né triệt để lỗi Linter */
    .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .status-badge-pending { background: #fee2e2; color: #991b1b; }
    .status-badge-shipping { background: #fef3c7; color: #92400e; }
    .status-badge-completed { background: #d1fae5; color: #065f46; }
</style>

<div style="width: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700;">Chào mừng trở lại, Thủ thư trưởng.</h1>
            <p style="color: #6b7280; font-size: 0.9rem;">Dưới đây là diễn biến tại hệ thống hôm nay.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button style="padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-weight: 600; background: white;">{{ now()->format('d/m/Y') }}</button>
            <a href="{{ route('admin.export.orders') }}" style="padding: 8px 16px; background: #1e3e36; color: white; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Xuất dữ liệu (CSV)
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px;">
        <div class="stat-card">
            <p style="color: #6b7280; font-size: 0.8rem; font-weight: 600; margin: 0;">Tổng doanh thu</p>
            <h2 style="font-size: 1.6rem; font-weight: 700; margin: 8px 0;">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h2>
        </div>
        <div class="stat-card">
            <p style="color: #6b7280; font-size: 0.8rem; font-weight: 600; margin: 0;">Đơn hàng mới</p>
            <h2 style="font-size: 1.6rem; font-weight: 700; margin: 8px 0;">{{ $totalOrders }}</h2>
        </div>
        <div class="stat-card">
            <p style="color: #6b7280; font-size: 0.8rem; font-weight: 600; margin: 0;">Tổng khách hàng</p>
            <h2 style="font-size: 1.6rem; font-weight: 700; margin: 8px 0;">{{ $totalUsers }}</h2>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 28px;">
        <div class="chart-container">
            <h3 style="font-weight: 700; margin: 0 0 20px 0; font-size: 1rem;">Biến động doanh thu hàng tháng</h3>
            <div style="height: 260px; position: relative;">
                <canvas id="revenueChart" data-chart="{{ json_encode($chartData) }}"></canvas>
            </div>
        </div>
        
        <div class="chart-container" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="font-weight: 700; margin: 0 0 20px 0; font-size: 1rem;">Sách bán chạy nhất</h3>
                @foreach($topBooks as $book)
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <img src="{{ $book->image_url }}" style="width: 42px; height: 54px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 600; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $book->title }}</div>
                        <div style="font-size: 0.8rem; color: #6b7280; margin-top: 2px;">{{ number_format($book->price, 0, ',', '.') }}đ</div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="/admin/books" style="font-size: 0.85rem; color: #1e3e36; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 10px;">Xem toàn bộ kho hàng →</a>
        </div>
    </div>

    <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-weight: 700; margin: 0; font-size: 1rem;">Đơn hàng gần đây</h3>
            <a href="/admin/orders" style="font-size: 0.85rem; font-weight: 600; color: #1e3e36; text-decoration: none;">Xem lịch sử →</a>
        </div>
        <table class="recent-orders-table">
            <thead>
                <tr>
                    <th>MÃ ĐƠN</th>
                    <th>KHÁCH HÀNG</th>
                    <th>SẢN PHẨM</th>
                    <th>TRẠNG THÁI</th>
                    <th>SỐ TIỀN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                @php
                    $statusText = $order->status == 'pending' ? 'Đang chờ' : ($order->status == 'shipping' ? 'Đang giao' : 'Đã giao');
                @endphp
                <tr>
                    <td style="font-weight: 600; color: #111827;">#INK-{{ $order->id }}</td>
                    <td style="font-weight: 500;">{{ $order->user->name }}</td>
                    <td style="color: #4b5563; max-width: 300px; line-height: 1.4;">
                        @foreach($order->books as $orderedBook)
                            <div>• {{ $orderedBook->title }}</div>
                        @endforeach
                    </td>
                    <td>
                        <span class="status-badge status-badge-{{ $order->status }}">
                            {{ $statusText }}
                        </span>
                    </td>
                    <td style="font-weight: 700; color: #111827;">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    const canvasElement = document.getElementById('revenueChart');
    const dbChartData = JSON.parse(canvasElement.getAttribute('data-chart'));

    const ctx = canvasElement.getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Th01', 'Th02', 'Th03', 'Th04', 'Th05', 'Th06', 'Th07', 'Th08', 'Th09', 'Th10', 'Th11', 'Th12'],
            datasets: [{
                label: 'Doanh thu (đ)',
                data: dbChartData, 
                backgroundColor: '#1e3e36', 
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false } },
                y: { 
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                }
            }
        }
    });
</script>
@endsection