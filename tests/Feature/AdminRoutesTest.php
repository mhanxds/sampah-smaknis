<?php

namespace Tests\Feature;

use App\Models\DetailSetoran;
use App\Models\KategoriSampah;
use App\Models\Nasabah;
use App\Models\Tabungan;
use App\Models\TransaksiSetoran;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true,
        ]);
        DB::purge('sqlite');
        Artisan::call('migrate:fresh', ['--force' => true]);
    }

    public function test_admin_can_open_all_admin_pages(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin_bank',
        ]);
        $studentUser = User::create([
            'name' => 'Siswa',
            'email' => 'siswa@example.test',
            'password' => 'password',
            'role' => 'siswa',
        ]);
        $staff = User::create([
            'name' => 'Petugas',
            'email' => 'petugas@example.test',
            'password' => 'password',
            'role' => 'petugas_timbangan',
        ]);
        $nasabah = Nasabah::create([
            'user_id' => $studentUser->id,
            'nama_siswa' => 'Siswa',
            'kelas' => 'X',
        ]);
        $tabungan = Tabungan::create(['nasabah_id' => $nasabah->id]);
        $kategori = KategoriSampah::create([
            'nama_sampah' => 'Kertas',
            'harga_per_kg' => 2500,
        ]);
        $transaksi = TransaksiSetoran::create([
            'nasabah_id' => $nasabah->id,
            'petugas_id' => $staff->id,
            'tanggal_setoran' => now(),
            'total_nilai' => 5000,
        ]);
        DetailSetoran::create([
            'transaksi_id' => $transaksi->id,
            'kategori_sampah_id' => $kategori->id,
            'berat_kg' => 2,
            'harga_per_kg' => 2500,
            'subtotal' => 5000,
        ]);

        $this->actingAs($admin);

        $urls = [
            route('admin.dashboard'),
            route('admin.users.index'),
            route('admin.users.create'),
            route('admin.users.edit', $staff),
            route('admin.nasabah.index'),
            route('admin.nasabah.create'),
            route('admin.nasabah.show', $nasabah),
            route('admin.nasabah.edit', $nasabah),
            route('admin.kategori-sampah.index'),
            route('admin.kategori-sampah.create'),
            route('admin.kategori-sampah.show', $kategori),
            route('admin.kategori-sampah.edit', $kategori),
            route('admin.transaksi.index'),
            route('admin.transaksi.show', $transaksi),
            route('admin.tabungan.index'),
            route('admin.tabungan.show', $tabungan),
            route('admin.laporan.index'),
        ];

        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_admin_routes_reject_guests_and_non_admin_users(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

        $student = User::create([
            'name' => 'Siswa',
            'email' => 'siswa@example.test',
            'password' => 'password',
            'role' => 'siswa',
        ]);

        $this->actingAs($student)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_create_users_categories_and_nasabah(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin_bank',
        ]);

        $this->actingAs($admin);

        $this->post(route('admin.users.store'), [
            'name' => 'Petugas Baru',
            'email' => 'staff@example.test',
            'password' => 'password123',
            'role' => 'petugas_sarpras',
        ])->assertRedirect(route('admin.users.index'));

        $staff = User::where('email', 'staff@example.test')->firstOrFail();
        $this->put(route('admin.users.update', $staff), [
            'name' => 'Petugas Diubah',
            'email' => 'staff@example.test',
            'role' => 'petugas_timbangan',
        ])->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'staff@example.test',
            'name' => 'Petugas Diubah',
            'role' => 'petugas_timbangan',
        ]);
        $this->delete(route('admin.users.destroy', $staff))
            ->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['email' => 'staff@example.test']);

        $this->post(route('admin.kategori-sampah.store'), [
            'nama_sampah' => 'Plastik',
            'harga_per_kg' => 3500,
        ])->assertRedirect(route('admin.kategori-sampah.index'));

        $kategori = KategoriSampah::where('nama_sampah', 'Plastik')->firstOrFail();
        $this->put(route('admin.kategori-sampah.update', $kategori), [
            'nama_sampah' => 'Plastik Bersih',
            'harga_per_kg' => 4000,
        ])->assertRedirect(route('admin.kategori-sampah.index'));
        $this->assertDatabaseHas('kategori_sampah', ['nama_sampah' => 'Plastik Bersih']);
        $this->delete(route('admin.kategori-sampah.destroy', $kategori))
            ->assertRedirect(route('admin.kategori-sampah.index'));
        $this->assertDatabaseMissing('kategori_sampah', ['nama_sampah' => 'Plastik Bersih']);

        $this->post(route('admin.nasabah.store'), [
            'nama_siswa' => 'Siswa Baru',
            'kelas' => 'XI',
            'email' => 'student@example.test',
            'password' => 'password123',
        ])->assertRedirect(route('admin.nasabah.index'));

        $this->assertDatabaseHas('nasabah', [
            'nama_siswa' => 'Siswa Baru',
            'kelas' => 'XI',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'student@example.test',
            'role' => 'siswa',
        ]);

        $nasabah = Nasabah::where('nama_siswa', 'Siswa Baru')->firstOrFail();
        $this->put(route('admin.nasabah.update', $nasabah), [
            'nama_siswa' => 'Siswa Diperbarui',
            'kelas' => 'XII',
            'email' => 'student-updated@example.test',
        ])->assertRedirect(route('admin.nasabah.index'));
        $this->assertDatabaseHas('nasabah', [
            'id' => $nasabah->id,
            'nama_siswa' => 'Siswa Diperbarui',
            'kelas' => 'XII',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'student-updated@example.test']);
        $this->delete(route('admin.nasabah.destroy', $nasabah))
            ->assertRedirect(route('admin.nasabah.index'));
        $this->assertDatabaseMissing('nasabah', ['id' => $nasabah->id]);
        $this->assertDatabaseMissing('users', ['email' => 'student-updated@example.test']);
    }
}
