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
    $table->unsignedBigInteger('phong_id');
    $table->unsignedBigInteger('nha_tro_id');
    $table->unsignedBigInteger('user_id'); // Thêm dòng này

    $table->integer('thang');
    $table->integer('nam');
    $table->integer('so_nguoi')->default(1);

    $table->float('chi_so_dien_dau')->default(0);
    $table->float('chi_so_dien_cuoi')->default(0);
    $table->float('chi_so_nuoc_dau')->default(0);
    $table->float('chi_so_nuoc_cuoi')->default(0);

    $table->integer('tong_tien')->default(0);
    $table->timestamps();

    $table->foreign('phong_id')->references('id')->on('phongs')->onDelete('cascade');
    $table->foreign('nha_tro_id')->references('id')->on('nha_tros')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Liên kết user
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
