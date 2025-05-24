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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_harga', 12, 2);
            $table->string('status')->default('pending');
            $table->string('metode_pembayaran')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->dateTime('tanggal_pesanan')->nullable();
            $table->string('bank_tujuan')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('pengiriman')->nullable();
            $table->timestamps();
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
