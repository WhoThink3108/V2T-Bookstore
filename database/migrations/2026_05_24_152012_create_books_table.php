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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại liên kết danh mục, nếu xóa danh mục thì sách thuộc danh mục đó tự mất (cascade)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Tên sách
            $table->string('slug')->unique(); // URL sách (ví dụ: the-silent-patient)
            $table->string('author'); // Tác giả
            $table->decimal('price', 10, 2); // Giá bán
            $table->integer('stock')->default(0); // Số lượng tồn kho
            $table->string('image_url')->nullable(); // Đường dẫn ảnh bìa
            $table->text('description')->nullable(); // Tóm tắt nội dung sách
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
