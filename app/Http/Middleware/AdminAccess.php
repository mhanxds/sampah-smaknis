<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        if (! in_array($user->role, ['admin', 'admin_bank'], true)) {
            abort(403, 'Anda tidak memiliki akses admin.');
        }

        return $next($request);
    }
}
