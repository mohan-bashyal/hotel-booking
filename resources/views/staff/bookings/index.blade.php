<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Front Desk</p>
                <h2 class="text-2xl font-bold text-slate-900">Staff Booking Dashboard</h2>
            </div>

            <form method="GET" action="{{ route('staff.dashboard') }}" class="flex flex-wrap items-center gap-2 rounded-xl border border-slate-200 bg-white p-2">
                <label for="status" class="px-2 text-sm font-medium text-slate-600">Filter</label>
                <select id="status" name="status" class="rounded-lg border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500">
                    <option value="">All statuses</option>
                    <option value="pending" @selected($status === 'pending')>Pending</option>
                    <option value="confirmed" @selected($status === 'confirmed')>Confirmed</option>
                    <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                </select>
                <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Apply
                </button>
            </form>
        </div>
    </x-slot>

    @php
        $pagePending = $bookings->getCollection()->where('status', 'pending')->count();
        $pageConfirmed = $bookings->getCollection()->where('status', 'confirmed')->count();
        $pageCancelled = $bookings->getCollection()->where('status', 'cancelled')->count();
    @endphp

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">This Page Total</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $bookings->count() }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Pending</p>
                <p class="mt-3 text-3xl font-bold text-amber-600">{{ $pagePending }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Confirmed</p>
                <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $pageConfirmed }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Cancelled</p>
                <p class="mt-3 text-3xl font-bold text-rose-600">{{ $pageCancelled }}</p>
            </article>
        </div>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Room</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Stay Dates</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Update</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $booking->room?->room_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <p class="font-semibold text-slate-800">{{ $booking->customer?->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500">{{ $booking->customer?->email ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-700">
                                    {{ $booking->check_in?->format('Y-m-d') }} to {{ $booking->check_out?->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ $booking->status === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : '' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('staff.bookings.update-status', $booking) }}" class="flex flex-wrap items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status" class="rounded-lg border-slate-300 text-sm focus:border-slate-500 focus:ring-slate-500" required>
                                            <option value="pending" @selected($booking->status === 'pending')>Pending</option>
                                            <option value="confirmed" @selected($booking->status === 'confirmed')>Confirmed</option>
                                            <option value="cancelled" @selected($booking->status === 'cancelled')>Cancelled</option>
                                        </select>

                                        <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                            Save
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">No bookings found for this filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div>
            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>
