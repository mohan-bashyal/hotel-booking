<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Property Operations</p>
                <h2 class="text-2xl font-bold text-slate-900">Admin Dashboard</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.rooms.index') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Manage Rooms
                </a>
                <a href="{{ route('admin.staffs.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Manage Staff
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Room Types</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $roomTypes }}</p>
                <p class="mt-2 text-xs text-slate-500">Configured categories for the property</p>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Rooms</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $rooms }}</p>
                <p class="mt-2 text-xs text-slate-500">Total listed rooms</p>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Staff Members</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $staffs }}</p>
                <p class="mt-2 text-xs text-slate-500">Assigned staff under this hotel</p>
            </article>
        </div>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h3 class="text-lg font-semibold text-slate-900">Management Shortcuts</h3>
                <p class="mt-1 text-sm text-slate-500">Use these shortcuts to keep inventory and team synced.</p>

                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    <a href="{{ route('admin.room-types.index') }}" class="rounded-xl border border-slate-200 p-4 hover:border-slate-400 hover:bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">Room Types</p>
                        <p class="mt-1 text-xs text-slate-500">Configure names, pricing, and capacity</p>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="rounded-xl border border-slate-200 p-4 hover:border-slate-400 hover:bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">Rooms</p>
                        <p class="mt-1 text-xs text-slate-500">Track room availability and status</p>
                    </a>
                    <a href="{{ route('admin.staffs.index') }}" class="rounded-xl border border-slate-200 p-4 hover:border-slate-400 hover:bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">Staff</p>
                        <p class="mt-1 text-xs text-slate-500">Onboard, edit, and manage permissions</p>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Property Ratios</h3>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Rooms per Type</span>
                        <span class="font-semibold text-slate-900">{{ $roomTypes > 0 ? number_format($rooms / $roomTypes, 1) : '0.0' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Staff per Room</span>
                        <span class="font-semibold text-slate-900">{{ $rooms > 0 ? number_format($staffs / $rooms, 2) : '0.00' }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
