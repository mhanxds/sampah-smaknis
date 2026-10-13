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
            return in_array(Auth::user()->role, ['admin', 'admin_bank'], true)
                ? redirect()->route('admin.dashboard')
                : redirect()->route('account.pending');
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

        if (! in_array($user->role, ['admin', 'admin_bank'], true)) {
            return redirect()->route('account.pending');
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
