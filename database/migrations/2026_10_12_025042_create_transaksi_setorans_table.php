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
        Schema::create('transaksi_setoran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabah')->restrictOnDelete();
            $table->foreignId('petugas_id')->constrained('users')->restrictOnDelete();
            $table->dateTime('tanggal_setoran');
            $table->index('tanggal_setoran');
            $table->decimal('total_nilai', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_setoran');
    }
};
