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
        Schema::create('hop_dong_thue_phongs', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
             $table->foreignId('nha_tro_id')->constrained('nha_tros')->onDelete('cascade');
            $table->date('ngay_bat_dau');
            $table->date('ngay_het_han')->nullable(); // ngày hết hạn hợp đồng
            $table->integer('gia_thue')->default(0);
            $table->integer('tien_coc')->nullable();
           
            $table->text('ghi_chu')->nullable();

            $table->boolean('active')->default(true); // còn hiệu lực

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hop_dong_thue_phongs');
    }
};
