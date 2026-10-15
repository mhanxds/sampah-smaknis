<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where(function ($query) use ($credentials) {
                $query->where('email', $credentials['identifier'])
                    ->orWhere('username', $credentials['identifier']);
            })
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['identifier' => 'Username/email atau kata sandi tidak valid.'])
                ->onlyInput('identifier');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectForRole($user->role, redirect()->intended(route('admin.dashboard')));
    }

    private function redirectForRole(string $role, ?RedirectResponse $intended = null): RedirectResponse
    {
        if (in_array($role, ['admin', 'admin_bank'], true)) {
            return $intended ?? redirect()->route('admin.dashboard');
        }

        if ($role === 'petugas_bank_sampah') {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('account.pending');
    }
}
