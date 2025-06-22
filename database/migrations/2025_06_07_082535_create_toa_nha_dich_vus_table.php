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
        Schema::create('toa_nha_dich_vus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nha_tro_id');
            $table->unsignedBigInteger('dich_vu_id');
            $table->enum('kieu_tinh', ['cong_to', 'dau_nguoi', 'co_dinh'])->default('cong_to'); //cong_to	Tính theo số đo công tơ (số điện, số nước, MB Internet...)
           
            $table->integer('don_gia')->default(0); // Giá cơ bản mặc định
            $table->timestamps();
            $table->foreign('nha_tro_id')->references('id')->on('nha_tros')->onDelete('cascade');
            $table->foreign('dich_vu_id')->references('id')->on('dich_vus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toa_nha_dich_vus');
    }
};
