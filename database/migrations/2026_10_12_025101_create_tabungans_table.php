<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->unique()->constrained('nasabah')->restrictOnDelete();
            $table->decimal('saldo', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabungan');
    }
};
