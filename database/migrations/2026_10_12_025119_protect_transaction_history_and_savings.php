<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });

        Schema::table('tabungan', function (Blueprint $table) {
            $table->dropForeign(['nasabah_id']);
            $table->foreign('nasabah_id')->references('id')->on('nasabah')->restrictOnDelete();
        });

        Schema::table('detail_setoran', function (Blueprint $table) {
            $table->dropForeign(['transaksi_id']);
            $table->foreign('transaksi_id')->references('id')->on('transaksi_setoran')->restrictOnDelete();
        });

        if (! Schema::hasIndex('transaksi_setoran', ['tanggal_setoran'])) {
            Schema::table('transaksi_setoran', function (Blueprint $table) {
                $table->index('tanggal_setoran');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasIndex('transaksi_setoran', ['tanggal_setoran'])) {
            Schema::table('transaksi_setoran', function (Blueprint $table) {
                $table->dropIndex(['tanggal_setoran']);
            });
        }

        Schema::table('detail_setoran', function (Blueprint $table) {
            $table->dropForeign(['transaksi_id']);
            $table->foreign('transaksi_id')->references('id')->on('transaksi_setoran')->cascadeOnDelete();
        });

        Schema::table('tabungan', function (Blueprint $table) {
            $table->dropForeign(['nasabah_id']);
            $table->foreign('nasabah_id')->references('id')->on('nasabah')->cascadeOnDelete();
        });

        Schema::table('nasabah', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
