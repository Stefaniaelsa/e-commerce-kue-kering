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
            $table->string('nama', 100); // Nama produk
            $table->text('deskripsi')->nullable(); // Deskripsi produk
            $table->decimal('harga', 10, 2); // Harga produk
            $table->integer('stok'); // Stok produk
            $table->string('gambar')->nullable(); // Gambar produk
           
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
