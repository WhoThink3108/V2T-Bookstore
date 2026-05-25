<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. TẠO TÀI KHOẢN MẪU
        // Tài khoản Admin dùng để test luồng quản trị
        User::create([
            'name' => 'Admin',
            'email' => 'admin@v2t.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Tài khoản Khách hàng dùng để test luồng mua sách
        User::create([
            'name' => 'Khách hàng',
            'email' => 'customer@v2t.com',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'status' => 'active',
        ]);

        // 2. TẠO THỂ LOẠI SÁCH MẪU
        $tieuThuyet = Category::create([
            'name' => 'Tiểu thuyết & Văn học',
            'slug' => Str::slug('Tiểu thuyết & Văn học'),
        ]);

        $trinhTham = Category::create([
            'name' => 'Trinh thám & Ly kỳ',
            'slug' => Str::slug('Trinh thám & Ly kỳ'),
        ]);

        $kinhTe = Category::create([
            'name' => 'Kinh tế & Quản trị',
            'slug' => Str::slug('Kinh tế & Quản trị'),
        ]);


        // 3. TẠO SÁCH MẪU
        // Sách thuộc thể loại Trinh thám
        Book::create([
            'category_id' => $trinhTham->id,
            'title' => 'The Silent Patient',
            'slug' => Str::slug('The Silent Patient'),
            'author' => 'Alex Michaelides',
            'price' => 250000,
            'stock' => 15,
            'image_url' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Cuộc đời của Alicia Berenson dường như hoàn hảo. Một họa sĩ nổi tiếng kết hôn với một nhiếp ảnh gia thời trang đang yêu, cô sống trong một ngôi nhà lớn với những ô cửa sổ lớn nhìn ra công viên ở một trong những khu vực đáng mơ ước nhất của London. Vào một buổi tối, chồng cô trở về nhà muộn và Alicia đã bắn vào mặt anh ta năm lần, rồi sau đó không bao giờ nói thêm một lời nào nữa.',
        ]);

        Book::create([
            'category_id' => $trinhTham->id,
            'title' => 'The Shadow of the Wind',
            'slug' => Str::slug('The Shadow of the Wind'),
            'author' => 'Carlos Ruiz Zafón',
            'price' => 320000,
            'stock' => 8,
            'image_url' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Barcelona, 1945: Thành phố đang hồi sinh sau cuộc Nội chiến, và Daniel, con trai của một nhà buôn sách cũ, đang đau buồn vì cái chết của mẹ mình, tìm thấy niềm an ủi trong một cuốn sách bí ẩn mang tên Bóng hình của gió.',
        ]);

        // Sách thuộc thể loại Văn học / Tiểu thuyết
        Book::create([
            'category_id' => $tieuThuyet->id,
            'title' => 'Klara and the Sun',
            'slug' => Str::slug('Klara and the Sun'),
            'author' => 'Kazuo Ishiguro',
            'price' => 285000,
            'stock' => 20,
            'image_url' => 'https://images.unsplash.com/photo-1612178991541-b48cc8e92a4d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Một cái nhìn độc đáo về thế giới hiện đại qua lăng kính của một người bạn nhân tạo, khám phá câu hỏi bản chất thực sự của tình yêu là gì.',
        ]);


        // Sách thuộc thể loại Kinh tế
        Book::create([
            'category_id' => $kinhTe->id,
            'title' => 'Atomic Habits',
            'slug' => Str::slug('Atomic Habits'),
            'author' => 'James Clear',
            'price' => 199000,
            'stock' => 50,
            'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Dù mục tiêu của bạn là gì, Thay đổi tí hon, Kết quả bất ngờ cũng cung cấp một bộ khung đã được chứng minh để cải thiện mỗi ngày.',
        ]);
        //Nhà cung cấp
        Supplier::create([
            
            'name' => 'Nhà xuất bản Trẻ',
            'contract_code' => '#TR-2023-01',
            'contact_name' => 'Nguyễn Văn An',
            'contact_title' => 'Giám đốc kinh doanh',
            'phone' => '090 123 4567',
            'email' => 'an.nv@nxb-tre.vn',
            'status' => 'active',
        ]);
        Supplier::create([
                'name' => 'Fahasa Distribution',
                'contract_code' => '#FA-2024-05',
                'contact_name' => 'Lê Thị Bình',
                'contact_title' => 'Quản lý kho',
                'phone' => '028 387 6543',
                'email' => 'binh.le@fahasa.com',
                'status' => 'paused',
        ]);
        Supplier::create([
                'name' => 'Đông Nam Books',
                'contract_code' => '#DN-2022-12',
                'contact_name' => 'Trần Minh Tâm',
                'contact_title' => 'Đại diện pháp luật',
                'phone' => '091 445 6789',
                'email' => 'tam.tm@dongnambooks.vn',
                'status' => 'active',
        ]);
        Supplier::create([
                'name' => 'Nhà xuất bản Kim Đồng',
                'contract_code' => '#KD-2025-02',
                'contact_name' => 'Phạm Thị Hòa',
                'contact_title' => 'Trưởng phòng cung ứng',
                'phone' => '024 394 3456',
                'email' => 'hoa.pt@nxbkimdong.com.vn',
                'status' => 'active',
        ]);
        
    }
}