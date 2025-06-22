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
        Schema::create('cong_tos', function (Blueprint $table) {
            $table->id();
                $table->foreignId('nha_tro_id')->constrained('nha_tros')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('cascade');
             $table->enum('loai', ['nuoc', 'dien']); // loại công tơ
    $table->integer('chi_so_dau')->default(0);
            $table->timestamps();
            $table->unique(['room_id', 'loai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cong_tos');
    }
};
