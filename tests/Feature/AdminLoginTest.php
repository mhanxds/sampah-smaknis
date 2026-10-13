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

    public function test_non_admin_accounts_can_sign_in_but_only_see_portal_notice(): void
    {
        User::create([
            'name' => 'Petugas',
            'email' => 'staff@example.test',
            'password' => 'staff-password',
            'role' => 'petugas_sarpras',
        ]);
        $staff = User::where('email', 'staff@example.test')->firstOrFail();

        $this->from(route('login'))
            ->post(route('login.store'), [
                'identifier' => 'staff@example.test',
                'password' => 'staff-password',
            ])
            ->assertRedirect(route('account.pending'));

        $this->assertAuthenticatedAs($staff);
        $this->get(route('account.pending'))
            ->assertOk()
            ->assertSee('portal untuk peran ini belum tersedia');
        $this->get(route('admin.dashboard'))->assertForbidden();
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
            ['identifier' => 'petugas2gmail.com', 'password' => 'petugas123', 'role' => 'petugas_sarpras', 'redirect' => 'account.pending'],
            ['identifier' => 'petugaspos@gmail.com', 'password' => 'petugaspos123', 'role' => 'petugas_timbangan', 'redirect' => 'account.pending'],
            ['identifier' => 'nasabah@gmail.com', 'password' => 'nasabah123', 'role' => 'siswa', 'redirect' => 'account.pending'],
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
