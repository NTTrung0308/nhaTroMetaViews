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
        Schema::create('transactions', function (Blueprint $table) {
             $table->id(); // Mã giao dịch nội bộ của hệ thống
            $table->string('transaction_code')->unique()->comment('Mã giao dịch duy nhất do hệ thống tự sinh ra, vd: TXN-HD101-16777215');

            // --- Liên kết tới các đối tượng khác ---
            $table->foreignId('hoa_don_id')->constrained('hoa_dons')->onDelete('cascade');
            $table->foreignId('user_id')->comment('Người thực hiện/khởi tạo giao dịch')->constrained('users')->onDelete('cascade');

            // --- Chi tiết chung của mọi giao dịch ---
            $table->unsignedBigInteger('amount')->comment('Số tiền giao dịch');
            $table->string('currency', 10)->default('VND')->comment('Loại tiền tệ');
            $table->text('description')->nullable()->comment('Mô tả/Nội dung giao dịch');

            // --- Cột "Phân Loại" - Cực kỳ quan trọng để dùng chung ---
            $table->string('gateway')->comment('Cổng thanh toán hoặc phương thức: vnpay, momo, zalopay, cash, bank_transfer...');

            // --- Thông tin từ Cổng thanh toán (linh hoạt) ---
            $table->string('gateway_transaction_code')->nullable()->comment('Mã giao dịch từ cổng thanh toán trả về');
            $table->json('metadata')->nullable()->comment('Lưu toàn bộ dữ liệu raw từ cổng thanh toán (IPN/Webhook) hoặc ghi chú cho giao dịch tiền mặt');

            // --- Trạng thái giao dịch ---
            // 'pending': Đang chờ xử lý/thanh toán
            // 'completed': Thành công
            // 'failed': Thất bại
            // 'cancelled': Người dùng hủy
            // 'refunded': Đã hoàn tiền
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            
            $table->timestamp('completed_at')->nullable()->comment('Thời gian giao dịch được xác nhận thành công');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
