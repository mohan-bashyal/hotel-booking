<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Control Center</p>
                <h2 class="text-2xl font-bold text-slate-900">Super Admin Dashboard</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('superadmin.hotels.index') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Manage Hotels
                </a>
                <a href="{{ route('superadmin.admins.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Manage Admins
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Hotels</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $hotels }}</p>
                <p class="mt-2 text-xs text-slate-500">Active properties in the platform</p>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Admins</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $admins }}</p>
                <p class="mt-2 text-xs text-slate-500">Property-level operators</p>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Staff</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $staff }}</p>
                <p class="mt-2 text-xs text-slate-500">Front desk and operations team</p>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Customers</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $customers }}</p>
                <p class="mt-2 text-xs text-slate-500">Registered booking users</p>
            </article>
        </div>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h3 class="text-lg font-semibold text-slate-900">Quick Actions</h3>
                <p class="mt-1 text-sm text-slate-500">Jump directly to high-frequency management pages.</p>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('superadmin.hotels.index') }}" class="rounded-xl border border-slate-200 p-4 hover:border-slate-400 hover:bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">Hotel Directory</p>
                        <p class="mt-1 text-xs text-slate-500">Create, edit, and maintain hotel records</p>
                    </a>
                    <a href="{{ route('superadmin.admins.index') }}" class="rounded-xl border border-slate-200 p-4 hover:border-slate-400 hover:bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">Admin Access</p>
                        <p class="mt-1 text-xs text-slate-500">Control admin accounts and status</p>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">System Mix</h3>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Hotels per Admin</span>
                        <span class="font-semibold text-slate-900">{{ $admins > 0 ? number_format($hotels / $admins, 1) : '0.0' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Staff per Hotel</span>
                        <span class="font-semibold text-slate-900">{{ $hotels > 0 ? number_format($staff / $hotels, 1) : '0.0' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Customers per Hotel</span>
                        <span class="font-semibold text-slate-900">{{ $hotels > 0 ? number_format($customers / $hotels, 1) : '0.0' }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
