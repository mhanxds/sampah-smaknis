<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pembina Bank Sampah',
                'email' => 'admin@gmail.com',
                'role' => 'admin_bank',
                'password' => 'admin123',
            ],
            [
                'name' => 'Staf Sarpras TU',
                'email' => 'petugas2gmail.com',
                'role' => 'petugas_sarpras',
                'password' => 'petugas123',
            ],
            [
                'name' => 'Petugas Pos Timbangan',
                'email' => 'petugaspos@gmail.com',
                'role' => 'petugas_timbangan',
                'password' => 'petugaspos123',
            ],
            [
                'name' => 'Siswa Nasabah',
                'email' => 'nasabah@gmail.com',
                'role' => 'siswa',
                'password' => 'nasabah123',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
