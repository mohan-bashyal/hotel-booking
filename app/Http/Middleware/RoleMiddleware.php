<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // If a running admin/staff account is deactivated, force logout immediately.
        if (in_array($user->role, ['admin', 'staff'], true) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $loginPath = match ($user->role) {
                'admin' => '/login/admin',
                'staff' => '/login/staff',
                default => '/login',
            };

            return redirect($loginPath)->withErrors([
                'email' => 'Your account is deactivated. Please contact your administrator.',
            ]);
        }

        if (!in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
