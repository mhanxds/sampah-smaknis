<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_setoran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi_setoran')->restrictOnDelete();
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampah')->restrictOnDelete();
            $table->decimal('berat_kg', 10, 3);
            $table->decimal('harga_per_kg', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_setoran');
    }
};
