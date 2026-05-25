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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Thuộc đơn hàng nào
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Cuốn sách nào
            $table->integer('quantity'); // Số lượng mua
            $table->decimal('price', 10, 2); // Lưu giá sách tại thời điểm mua (tránh trường hợp sau này sách đổi giá)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
