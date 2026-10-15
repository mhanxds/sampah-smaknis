<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'siswa')
            ->update(['role' => 'nasabah']);
    }

    public function down(): void
    {
        // Keep normalized roles when rolling back; nasabah accounts may have been added since.
    }
};
