<x-guest-layout>
    <div class="space-y-2">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Customer Onboarding</p>
        <h2 class="text-2xl font-bold text-slate-900">Create Your Booking Account</h2>
        <p class="text-sm text-slate-600">Register to browse rooms and place hotel bookings instantly.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-800 focus:border-slate-500 focus:ring-slate-500">
            @error('name')
                <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-800 focus:border-slate-500 focus:ring-slate-500">
            @error('email')
                <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-800 focus:border-slate-500 focus:ring-slate-500">
            @error('password')
                <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-800 focus:border-slate-500 focus:ring-slate-500">
            @error('password_confirmation')
                <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
            Create Account
        </button>

        <p class="text-center text-sm text-slate-600">
            Already registered?
            <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">Go to login</a>
        </p>
    </form>
</x-guest-layout>
