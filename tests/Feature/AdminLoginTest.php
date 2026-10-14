<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminLoginTest extends TestCase
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

    public function test_admin_can_sign_in_with_valid_admin_credentials(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'admin-password',
            'role' => 'admin_bank',
        ]);

        $this->get(route('login'))->assertOk();

        $this->post(route('login.store'), [
            'identifier' => 'admin@example.test',
            'password' => 'admin-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs(
            User::where('email', 'admin@example.test')->firstOrFail()
        );
        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_petugas_can_sign_in_to_their_dashboard_but_not_the_admin_area(): void
    {
        User::create([
            'name' => 'Petugas',
            'email' => 'staff@example.test',
            'password' => 'staff-password',
            'role' => 'petugas_bank_sampah',
        ]);
        $staff = User::where('email', 'staff@example.test')->firstOrFail();

        $this->from(route('login'))
            ->post(route('login.store'), [
                'identifier' => 'staff@example.test',
                'password' => 'staff-password',
            ])
            ->assertRedirect(route('petugas.dashboard'));

        $this->assertAuthenticatedAs($staff);
        $this->get(route('petugas.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Petugas')
            ->assertSee('Setoran terbaru');
        $this->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_nasabah_cannot_access_the_petugas_dashboard(): void
    {
        $nasabah = User::create([
            'name' => 'Nasabah',
            'email' => 'nasabah@example.test',
            'password' => 'password',
            'role' => 'nasabah',
        ]);

        $this->actingAs($nasabah)
            ->get(route('petugas.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_logout_clears_the_authenticated_session(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin_bank',
        ]);

        $this->actingAs($admin)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertFalse(Auth::check());
    }

    public function test_all_seeded_accounts_can_authenticate_using_their_existing_values(): void
    {
        Artisan::call('db:seed');

        $accounts = [
            ['identifier' => 'admin@gmail.com', 'password' => 'admin123', 'role' => 'admin_bank', 'redirect' => 'admin.dashboard'],
            ['identifier' => 'petugas2gmail.com', 'password' => 'petugas123', 'role' => 'petugas_bank_sampah', 'redirect' => 'petugas.dashboard'],
            ['identifier' => 'petugaspos@gmail.com', 'password' => 'petugaspos123', 'role' => 'petugas_bank_sampah', 'redirect' => 'petugas.dashboard'],
            ['identifier' => 'nasabah@gmail.com', 'password' => 'nasabah123', 'role' => 'nasabah', 'redirect' => 'account.pending'],
        ];

        foreach ($accounts as $account) {
            $response = $this->post(route('login.store'), [
                'identifier' => $account['identifier'],
                'password' => $account['password'],
            ]);

            $response->assertRedirect(route($account['redirect']));
            $this->assertAuthenticated();
            $this->assertDatabaseHas('users', [
                'email' => $account['identifier'],
                'role' => $account['role'],
            ]);
            $this->post(route('logout'))->assertRedirect(route('login'));
            $this->assertGuest();
        }
    }
}
