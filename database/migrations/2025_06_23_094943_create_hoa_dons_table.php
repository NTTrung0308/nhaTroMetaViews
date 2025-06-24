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
        Schema::create('hoa_dons', function (Blueprint $table) {
           $table->id();
            $table->string('ma_hoa_don')->unique(); // Mã hoá đơn duy nhất, vd: HD-P101-T072023

            // --- Foreign Keys - Liên kết tới các bảng khác ---
            $table->foreignId('nha_tro_id')->constrained('nha_tros')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người thuê chính
            $table->foreignId('hop_dong_thue_phong_id')->nullable()->constrained()->onDelete('set null'); // Liên kết đến hợp đồng tại thời điểm xuất hoá đơn

            // --- Thông tin chu kỳ hoá đơn ---
            $table->integer('thang');
            $table->integer('nam');
            $table->date('ngay_tao_hoa_don'); // Ngày chốt/tạo hoá đơn
            $table->date('han_thanh_toan'); // Hạn chót thanh toán

            // --- Chi tiết các khoản phí (lưu lại giá trị tại thời điểm tạo) ---
            // Lý do: Để đảm bảo dữ liệu không thay đổi nếu sau này bạn cập nhật giá thuê hay giá dịch vụ
            $table->unsignedBigInteger('tien_thue_phong')->default(0);
            $table->unsignedBigInteger('tien_dien')->default(0);
            $table->unsignedBigInteger('tien_nuoc')->default(0);
            
            // Dùng JSON để lưu các dịch vụ khác một cách linh hoạt (Internet, vệ sinh, xe...)
            // Ví dụ: [{"ten_dich_vu": "Internet", "don_gia": 100000, "thanh_tien": 100000}, ...]
            $table->json('chi_tiet_dich_vu_khac')->nullable();
            
            $table->unsignedBigInteger('tong_phu_phi')->default(0); // Tổng các dịch vụ trong chi_tiet_dich_vu_khac

            // --- Tổng kết & Thanh toán ---
            $table->unsignedBigInteger('no_ky_truoc')->default(0); // Nợ cũ từ hoá đơn tháng trước chuyển sang
            $table->unsignedBigInteger('tong_tien'); // Tổng tiền của kỳ này: tien_thue_phong + tien_dien + tien_nuoc + tong_phu_phi
            $table->unsignedBigInteger('da_thanh_toan')->default(0); // Số tiền khách đã trả cho hoá đơn này
            
            // Cột ảo để tính toán số tiền còn nợ, rất tiện lợi
            $table->bigInteger('con_no')->storedAs('tong_tien + no_ky_truoc - da_thanh_toan');
            
            // --- Trạng thái & Ghi chú ---
            $table->enum('trang_thai', ['chua_thanh_toan', 'da_thanh_toan', 'qua_han', 'da_huy'])->default('chua_thanh_toan');
            $table->text('ghi_chu')->nullable(); // Ghi chú của chủ nhà
            $table->text('ghi_chu_nguoi_thue')->nullable(); // Ghi chú/phản hồi của người thuê

            $table->timestamps();

            // Ràng buộc để đảm bảo mỗi phòng chỉ có một hoá đơn mỗi tháng
            $table->unique(['room_id', 'thang', 'nam']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
