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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('max_uses')->nullable(); //số lượng người có thể sử dụng voucher
            $table->integer('max_uses_user')->nullable(); //số lần sử dụng tối đa của mỗi người
            $table->enum('type',['percent','fixed'])->default('fixed'); // phiếu giảm giá là phần trăm hay giá cố định
            $table->double('discount_amount', 10, 2); // số tiền giảm giá
            $table->double('min_amount', 10, 2)->nullable(); // số tiền tối thiểu để sử dụng voucher
            $table->integer('status')->default(1); // trạng thái hoạt động của voucher
            $table->timestamp('starts_at')->nullable(); // Ngày bắt đầu sử dụng
            $table->timestamp('expires_at')->nullable(); // Ngày kết thúc sử dụng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
