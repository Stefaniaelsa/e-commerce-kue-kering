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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_favorit')->default(false);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->timestamps();

            $table->foreign('id_admin')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
