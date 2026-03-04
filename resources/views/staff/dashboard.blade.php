<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Front Desk</p>
                <h2 class="text-2xl font-bold text-slate-900">Staff Dashboard</h2>
            </div>
            <a href="{{ route('staff.bookings.index') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Go To Bookings
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Booking Operations</h3>
            <p class="mt-2 text-sm text-slate-600">
                Manage customer booking statuses from the bookings dashboard.
            </p>
            <a href="{{ route('staff.bookings.index') }}" class="mt-6 inline-flex rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                Open Booking Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
