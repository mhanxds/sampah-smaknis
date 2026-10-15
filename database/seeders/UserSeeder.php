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
                'name' => 'Petugas Bank Sampah',
                'email' => 'petugas2gmail.com',
                'role' => 'petugas_bank_sampah',
                'password' => 'petugas123',
            ],
            [
                'name' => 'Petugas Pos Timbangan',
                'email' => 'petugaspos@gmail.com',
                'role' => 'petugas_bank_sampah',
                'password' => 'petugaspos123',
            ],
            [
                'name' => 'Siswa Nasabah',
                'email' => 'nasabah@gmail.com',
                'role' => 'nasabah',
                'password' => 'nasabah123',
            ],
        ];

        foreach ($users as $user) {
            $existingUser = User::where('email', $user['email'])->first();

            if ($existingUser) {
                $existingUser->update([
                    'name' => $user['name'],
                    'role' => $user['role'],
                ]);
                continue;
            }

            User::create($user);
        }
    }
}
