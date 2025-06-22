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
        Schema::create('dien_nuoc_theo_phongs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nha_tro_id');
            $table->unsignedBigInteger('room_id');
            $table->integer('thang');
            $table->integer('nam');

            $table->integer('chi_so_dien')->nullable();     // Nhập tay
            $table->integer('so_m3_nuoc')->nullable();       // Nếu tính theo nước
            $table->integer('so_nguoi')->nullable();         // Nếu tính theo đầu người
 $table->integer('tieu_thu_dien')->nullable();
        $table->integer('tieu_thu_nuoc')->nullable();
            $table->timestamps();

            $table->unique(['nha_tro_id', 'room_id', 'thang', 'nam']); // Một dòng duy nhất mỗi phòng/tháng/năm
            $table->foreign('nha_tro_id')->references('id')->on('nha_tros')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dien_nuoc_theo_phongs');
    }
};
