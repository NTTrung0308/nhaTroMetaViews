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
        Schema::create('license_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key', 64)->unique();     // license key (random 32 ký tự hex, nhưng để 64 cho an toàn)
            $table->unsignedBigInteger('user_id')->nullable(); // user được gán key
            $table->integer('max_rooms')->default(0); // số lượng phòng được phép tạo
            $table->boolean('is_active')->default(true); // trạng thái key
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_keys');
    }
};
