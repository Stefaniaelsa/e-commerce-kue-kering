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
        Schema::create('item_keranjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('id_varian')->nullable();
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_keranjang')->references('id')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_varian')->references('id')->on('product_variants')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_keranjang');
    }
};
