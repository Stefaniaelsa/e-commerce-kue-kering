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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'dikirim', 'selesai'])->default('menunggu');
            $table->text('alamat_pengiriman')->nullable();
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->enum('pengiriman', ['gojek', 'ambil ditempat']);
            $table->string('metode_pembayaran');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
