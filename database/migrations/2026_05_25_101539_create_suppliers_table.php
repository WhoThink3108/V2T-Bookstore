<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên Nhà cung cấp (Ví dụ: Nhà xuất bản Trẻ)
            $table->string('contract_code'); // Mã hợp đồng (#TR-2023-01)
            $table->string('contact_name'); // Người liên hệ
            $table->string('contact_title'); // Chức vụ người liên hệ
            $table->string('phone');
            $table->string('email');
            $table->string('status')->default('active'); // active (Đang hoạt động), paused (Tạm dừng)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
