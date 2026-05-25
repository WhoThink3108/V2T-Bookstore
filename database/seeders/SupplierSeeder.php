<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Nhà xuất bản Trẻ',
                'contract_code' => '#TR-2023-01',
                'contact_name' => 'Nguyễn Văn An',
                'contact_title' => 'Giám đốc kinh doanh',
                'phone' => '090 123 4567',
                'email' => 'an.nv@nxb-tre.vn',
                'status' => 'active',
            ],
            [
                'name' => 'Fahasa Distribution',
                'contract_code' => '#FA-2024-05',
                'contact_name' => 'Lê Thị Bình',
                'contact_title' => 'Quản lý kho',
                'phone' => '028 387 6543',
                'email' => 'binh.le@fahasa.com',
                'status' => 'paused',
            ],
            [
                'name' => 'Đông Nam Books',
                'contract_code' => '#DN-2022-12',
                'contact_name' => 'Trần Minh Tâm',
                'contact_title' => 'Đại diện pháp luật',
                'phone' => '091 445 6789',
                'email' => 'tam.tm@dongnambooks.vn',
                'status' => 'active',
            ],
            [
                'name' => 'Nhà xuất bản Kim Đồng',
                'contract_code' => '#KD-2025-02',
                'contact_name' => 'Phạm Thị Hòa',
                'contact_title' => 'Trưởng phòng cung ứng',
                'phone' => '024 394 3456',
                'email' => 'hoa.pt@nxbkimdong.com.vn',
                'status' => 'active',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}