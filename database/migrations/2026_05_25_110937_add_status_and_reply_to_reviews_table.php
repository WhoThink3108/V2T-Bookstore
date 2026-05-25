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
        Schema::table('reviews', function (Blueprint $table) {
            // Kiểm tra nếu chưa có cột status thì tự động thêm vào
            if (!Schema::hasColumn('reviews', 'status')) {
                $table->string('status')->default('pending')->after('comment');
            }
            // Kiểm tra nếu chưa có cột is_purchased thì tự động thêm vào
            if (!Schema::hasColumn('reviews', 'is_purchased')) {
                $table->boolean('is_purchased')->default(true)->after('status');
            }
            // Kiểm tra nếu chưa có cột admin_reply thì tự động thêm vào
            if (!Schema::hasColumn('reviews', 'admin_reply')) {
                $table->text('admin_reply')->nullable()->after('is_purchased');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['status', 'is_purchased', 'admin_reply']);
        });
    }
};