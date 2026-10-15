<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereIn('role', ['petugas_sarpras', 'petugas_timbangan'])
            ->update(['role' => 'petugas_bank_sampah']);
    }

    public function down(): void
    {
        // The former roles cannot be distinguished after they have been combined.
    }
};
