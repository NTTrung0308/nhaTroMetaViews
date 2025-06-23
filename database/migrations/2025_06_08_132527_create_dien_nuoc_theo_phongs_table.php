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
            $table->integer('chi_so_dien_truoc')->default(0);
            $table->integer('chi_so_dien')->default(0);
            $table->integer('so_m3_nuoc_truoc')->default(0);
            $table->integer('so_m3_nuoc_sau')->default(0);
            $table->integer('so_nguoi')->default(1);
            $table->integer('dien_tieu_thu')->default(0);
            $table->integer('nuoc_tieu_thu')->default(0);
               $table->boolean('trang_thai_chot')->default(false);
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
