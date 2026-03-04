<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthenticatedSessionController extends Controller
{
    private array $roleMap = [
        'superadmin' => 'super_admin',
        'admin' => 'admin',
        'staff' => 'staff',
    ];

    public function create(Request $request)
    {
        $urlRole = $request->route('role');
        $role = $this->roleMap[$urlRole] ?? 'customer';

        return view('auth.login', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'staff', 'customer'])],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->role !== $request->role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                'email' => 'Unauthorized role login',
            ]);
        }

        // Inactive admin/staff accounts cannot log in.
        if (in_array($user->role, ['admin', 'staff'], true) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Your account is deactivated. Please contact your administrator.',
            ]);
        }

        $request->session()->regenerate();

        return match ($request->role) {
            'super_admin' => redirect('/superadmin/dashboard'),
            'admin' => redirect('/admin/dashboard'),
            'staff' => redirect('/staff/dashboard'),
            default => redirect('/customer/rooms'),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
