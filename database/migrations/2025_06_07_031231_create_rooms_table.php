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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nha_tro_id')->constrained('nha_tros')->onDelete('cascade');
            $table->string('ten_phong');
            $table->string('ma_phong')->nullable();
            $table->integer('dien_tich')->nullable();
            $table->string('bancong')->nullable();
            $table->integer('so_khach')->nullable();
            $table->enum('loai_phong', ['van_phong', 'can_ho', 'phong_cho_thue', 'khac'])->default('can_ho');
            $table->integer('gia_thue')->default(0); // VND
            $table->boolean('da_thue')->default(false);
            $table->json('images')->nullable();//Ảnh demo phòng trọ
            $table->text('ghi_chu')->nullable();
            $table->string('status')->default('trong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
