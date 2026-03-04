<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-950">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.18),_transparent_50%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.12),_transparent_45%)]"></div>

            <div class="relative mx-auto grid min-h-screen w-full max-w-7xl items-center gap-8 px-4 py-8 sm:px-6 lg:grid-cols-2 lg:px-8">
                <section class="hidden rounded-3xl border border-white/10 bg-white/5 p-10 text-white backdrop-blur lg:block">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-sm font-bold text-slate-900">HB</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Hospitality Suite</p>
                            <h1 class="text-xl font-semibold">Hotel Room Booking System</h1>
                        </div>
                    </a>

                    <h2 class="mt-12 text-4xl font-bold leading-tight">Run bookings, rooms, and teams from one modern workspace.</h2>
                    <p class="mt-4 max-w-md text-sm text-slate-300">Unified access for superadmin, admin, staff, and customers with secure role-based login and booking operations.</p>

                    <div class="mt-10 grid grid-cols-2 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs text-slate-300">Live Operations</p>
                            <p class="mt-2 text-2xl font-semibold">24/7</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs text-slate-300">Role Based Access</p>
                            <p class="mt-2 text-2xl font-semibold">4 Roles</p>
                        </div>
                    </div>
                </section>

                <section class="w-full lg:pl-8">
                    <div class="mx-auto w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl sm:p-8">
                        <a href="{{ url('/') }}" class="mb-6 inline-flex items-center gap-2 text-slate-700 lg:hidden">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900 text-xs font-semibold text-white">HB</span>
                            <span class="text-sm font-semibold">Hotel Booking</span>
                        </a>

                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
