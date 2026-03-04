<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .booking-modern {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }

        .glass-card {
            backdrop-filter: blur(10px);
            background: linear-gradient(145deg, rgba(255,255,255,0.92), rgba(248,250,252,0.86));
            border: 1px solid rgba(148,163,184,0.22);
        }

        .room-gradient {
            background: radial-gradient(circle at top right, rgba(14,165,233,0.16), transparent 45%),
                        radial-gradient(circle at bottom left, rgba(34,197,94,0.10), transparent 40%),
                        linear-gradient(180deg, #ffffff, #f8fafc);
        }
    </style>

    <x-slot name="header">
        <div class="booking-modern">
            <div class="rounded-2xl bg-gradient-to-r from-cyan-600 via-sky-600 to-blue-700 p-6 text-white shadow-lg">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-100">Customer Portal</p>
                        <h2 class="mt-1 text-2xl font-extrabold md:text-3xl">Find Your Perfect Stay</h2>
                        <p class="mt-1 text-sm text-cyan-100">Search verified rooms, check live availability, and book instantly.</p>
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-semibold">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m4 9H3a2 2 0 01-2-2V7a2 2 0 012-2h18a2 2 0 012 2v11a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ now()->format('D, M d Y') }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="booking-modern mx-auto max-w-7xl space-y-6 p-4 md:p-6">
        @if (session('success'))
            <div class="glass-card rounded-xl border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="glass-card rounded-xl border border-rose-200 px-4 py-3 text-sm text-rose-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="glass-card rounded-2xl p-4 shadow-sm md:p-5">
            <div class="mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4z"></path>
                </svg>
                <h3 class="text-base font-bold text-slate-800">Search Availability</h3>
            </div>

            <form method="GET" action="{{ route('customer.rooms.index') }}" class="grid gap-4 md:grid-cols-4 md:items-end">
                <div>
                    <label for="check_in" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Check In</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m4 9H3a2 2 0 01-2-2V7a2 2 0 012-2h18a2 2 0 012 2v11a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <input id="check_in" name="check_in" type="date" value="{{ old('check_in', $checkIn) }}"
                            min="{{ now()->toDateString() }}"
                            class="w-full rounded-xl border-slate-300 py-2 pl-9 pr-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                    </div>
                </div>

                <div>
                    <label for="check_out" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Check Out</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m4 9H3a2 2 0 01-2-2V7a2 2 0 012-2h18a2 2 0 012 2v11a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <input id="check_out" name="check_out" type="date" value="{{ old('check_out', $checkOut) }}"
                            min="{{ old('check_in', $checkIn ?: now()->toDateString()) }}"
                            class="w-full rounded-xl border-slate-300 py-2 pl-9 pr-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                    </div>
                </div>

                <button type="submit" class="h-10 rounded-xl bg-slate-900 px-4 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Search Rooms
                </button>

                <a href="{{ route('customer.rooms.index') }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-slate-300 px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    Reset Filters
                </a>
            </form>

            <p class="mt-4 text-sm {{ $hasDates ? 'text-emerald-700' : 'text-amber-700' }}">
                @if ($hasDates)
                    Availability from <span class="font-bold">{{ $checkIn }}</span> to <span class="font-bold">{{ $checkOut }}</span>.
                @else
                    Pick both dates to see only available rooms and make a booking.
                @endif
            </p>
        </section>

        <section>
            <div class="mb-3 flex items-center justify-between gap-3">
                <h3 class="text-lg font-extrabold text-slate-900">Available Rooms</h3>
                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-bold text-sky-700">{{ $rooms->count() }} found</span>
            </div>

            @if ($rooms->isEmpty())
                <div class="glass-card rounded-2xl p-8 text-center text-slate-500">
                    No rooms found for your criteria.
                </div>
            @else
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($rooms as $room)
                        <article class="room-gradient rounded-2xl border border-slate-200 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ $room->hotel?->name ?? 'Hotel' }}</p>
                                    <h4 class="mt-1 text-lg font-bold text-slate-900">Room {{ $room->room_number }}</h4>
                                    <p class="text-sm text-slate-600">{{ $room->roomType?->name ?? 'Room Type' }}</p>
                                </div>
                                <div class="rounded-xl bg-white px-3 py-2 text-right shadow-sm">
                                    <p class="text-[10px] uppercase tracking-wide text-slate-500">Per Night</p>
                                    <p class="text-base font-extrabold text-slate-900">NPR {{ number_format((float) ($room->roomType?->price ?? 0), 2) }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold text-slate-600">
                                <span class="inline-flex items-center gap-1 rounded-full bg-white px-2.5 py-1 shadow-sm">
                                    <svg class="h-3.5 w-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3"></path></svg>
                                    Fast Check-in
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-white px-2.5 py-1 shadow-sm">
                                    <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Verified Room
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-white px-2.5 py-1 shadow-sm">
                                    <svg class="h-3.5 w-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v1H8a2 2 0 00-2 2v2h12v-2a2 2 0 00-2-2h-1v-1c0-1.657-1.343-3-3-3z"></path></svg>
                                    Secure Booking
                                </span>
                            </div>

                            <form method="POST" action="{{ route('customer.bookings.store') }}" class="mt-4 space-y-3">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">

                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-bold uppercase tracking-wide text-slate-500">Check In</label>
                                        <input type="date" name="check_in"
                                            value="{{ old('check_in', $checkIn) }}"
                                            min="{{ now()->toDateString() }}"
                                            class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-bold uppercase tracking-wide text-slate-500">Check Out</label>
                                        <input type="date" name="check_out"
                                            value="{{ old('check_out', $checkOut) }}"
                                            min="{{ old('check_in', $checkIn ?: now()->toDateString()) }}"
                                            class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                    </div>
                                </div>

                                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-sky-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h.01M11 15h2m2 0h2m-7 4h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Book This Room
                                </button>
                            </form>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <div class="mb-3 flex items-center gap-2">
                <svg class="h-5 w-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h5m0 0l-2-2m2 2l-2 2m-7 4h8a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-extrabold text-slate-900">My Bookings</h3>
            </div>

            <div class="space-y-3 md:hidden">
                @forelse ($myBookings as $booking)
                    @php
                        $nights = max(1, (int) $booking->check_in?->diffInDays($booking->check_out));
                        $nightly = (float) ($booking->room?->roomType?->price ?? 0);
                        $total = $nights * $nightly;
                    @endphp
                    <article class="glass-card rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-sm font-bold text-slate-900">{{ $booking->room?->hotel?->name ?? 'N/A' }}</h4>
                            <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-bold
                                {{ $booking->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">Room {{ $booking->room?->room_number ?? 'N/A' }} - {{ $booking->room?->roomType?->name ?? 'N/A' }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $booking->check_in?->format('Y-m-d') }} to {{ $booking->check_out?->format('Y-m-d') }}</p>
                        <p class="mt-2 text-sm font-extrabold text-slate-900">NPR {{ number_format($total, 2) }}</p>
                    </article>
                @empty
                    <div class="glass-card rounded-xl p-5 text-center text-sm text-slate-500">You have not placed any bookings yet.</div>
                @endforelse
            </div>

            <div class="hidden overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm md:block">
                <table class="w-full border-collapse">
                    <thead class="bg-slate-900 text-white">
                        <tr>
                            <th class="p-3 text-left text-xs font-bold uppercase tracking-wide">Hotel</th>
                            <th class="p-3 text-left text-xs font-bold uppercase tracking-wide">Room</th>
                            <th class="p-3 text-left text-xs font-bold uppercase tracking-wide">Type</th>
                            <th class="p-3 text-left text-xs font-bold uppercase tracking-wide">Dates</th>
                            <th class="p-3 text-left text-xs font-bold uppercase tracking-wide">Amount</th>
                            <th class="p-3 text-left text-xs font-bold uppercase tracking-wide">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($myBookings as $booking)
                            @php
                                $nights = max(1, (int) $booking->check_in?->diffInDays($booking->check_out));
                                $nightly = (float) ($booking->room?->roomType?->price ?? 0);
                                $total = $nights * $nightly;
                            @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="p-3 text-sm text-slate-700">{{ $booking->room?->hotel?->name ?? 'N/A' }}</td>
                                <td class="p-3 text-sm font-semibold text-slate-800">{{ $booking->room?->room_number ?? 'N/A' }}</td>
                                <td class="p-3 text-sm text-slate-700">{{ $booking->room?->roomType?->name ?? 'N/A' }}</td>
                                <td class="p-3 text-sm text-slate-700">{{ $booking->check_in?->format('Y-m-d') }} to {{ $booking->check_out?->format('Y-m-d') }}</td>
                                <td class="p-3 text-sm font-bold text-slate-900">NPR {{ number_format($total, 2) }}</td>
                                <td class="p-3">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold
                                        {{ $booking->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : '' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-sm text-slate-500">You have not placed any bookings yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $myBookings->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
