<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="space-y-2">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Secure Access</p>
        <h2 class="text-2xl font-bold text-slate-900">{{ ucfirst(str_replace('_', ' ', $role)) }} Login</h2>
        <p class="text-sm text-slate-600">Sign in to continue your hotel booking workflow.</p>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-2 rounded-xl bg-slate-100 p-1 text-xs font-semibold text-slate-600 sm:grid-cols-4">
        <a href="{{ url('/login/superadmin') }}" class="rounded-lg px-2 py-2 text-center {{ $role === 'super_admin' ? 'bg-white text-slate-900 shadow-sm' : 'hover:bg-white/70' }}">Super Admin</a>
        <a href="{{ url('/login/admin') }}" class="rounded-lg px-2 py-2 text-center {{ $role === 'admin' ? 'bg-white text-slate-900 shadow-sm' : 'hover:bg-white/70' }}">Admin</a>
        <a href="{{ url('/login/staff') }}" class="rounded-lg px-2 py-2 text-center {{ $role === 'staff' ? 'bg-white text-slate-900 shadow-sm' : 'hover:bg-white/70' }}">Staff</a>
        <a href="{{ route('login') }}" class="rounded-lg px-2 py-2 text-center {{ $role === 'customer' ? 'bg-white text-slate-900 shadow-sm' : 'hover:bg-white/70' }}">Customer</a>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <input type="hidden" name="role" value="{{ $role }}">

        <div>
            <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-800 focus:border-slate-500 focus:ring-slate-500">
            @error('email')
                <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-800 focus:border-slate-500 focus:ring-slate-500">
            @error('password')
                <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
            Log In
        </button>

        @if ($role === 'customer')
            <p class="text-center text-sm text-slate-600">
                New customer?
                <a href="{{ route('register') }}" class="font-semibold text-slate-900 hover:underline">Create account</a>
            </p>
        @endif
    </form>
</x-guest-layout>
