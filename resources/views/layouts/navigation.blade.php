@php
    $user = auth()->user();
    $role = $user->role;

    $dashboardRoute = match ($role) {
        'super_admin' => route('superadmin.dashboard'),
        'admin' => route('admin.dashboard'),
        'staff' => route('staff.dashboard'),
        default => route('customer.rooms.index'),
    };

    $dashboardLabel = match ($role) {
        'super_admin' => 'Super Admin',
        'admin' => 'Admin Panel',
        'staff' => 'Staff Desk',
        default => 'Customer Area',
    };

    $navItems = match ($role) {
        'super_admin' => [
            ['label' => 'Overview', 'route' => route('superadmin.dashboard'), 'active' => 'superadmin.dashboard'],
            ['label' => 'Hotels', 'route' => route('superadmin.hotels.index'), 'active' => 'superadmin.hotels.*'],
            ['label' => 'Admins', 'route' => route('superadmin.admins.index'), 'active' => 'superadmin.admins.*'],
        ],
        'admin' => [
            ['label' => 'Overview', 'route' => route('admin.dashboard'), 'active' => 'admin.dashboard'],
            ['label' => 'Room Types', 'route' => route('admin.room-types.index'), 'active' => 'admin.room-types.*'],
            ['label' => 'Rooms', 'route' => route('admin.rooms.index'), 'active' => 'admin.rooms.*'],
            ['label' => 'Staff', 'route' => route('admin.staffs.index'), 'active' => 'admin.staffs.*'],
        ],
        'staff' => [
            ['label' => 'Overview', 'route' => route('staff.dashboard'), 'active' => 'staff.dashboard'],
            ['label' => 'Bookings', 'route' => route('staff.bookings.index'), 'active' => 'staff.bookings.*'],
        ],
        default => [
            ['label' => 'Browse Rooms', 'route' => route('customer.rooms.index'), 'active' => 'customer.rooms.*'],
        ],
    };

    $notificationsEnabled = in_array($role, ['staff', 'admin', 'super_admin'], true);
    $bookingNotifications = collect();

    if ($notificationsEnabled) {
        $bookingNotifications = \App\Models\BookingNotification::query()
            ->with(['booking.room:id,room_number', 'booking.customer:id,name'])
            ->where('recipient_user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->limit(8)
            ->get()
            ->filter(fn ($notification) => $notification->isActionableFor($user))
            ->values();
    }
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-6">
            <a href="{{ $dashboardRoute }}" class="inline-flex items-center gap-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900 text-sm font-semibold text-white">HB</span>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Hotel Booking</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $dashboardLabel }}</p>
                </div>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                @foreach ($navItems as $item)
                    @php $active = request()->routeIs($item['active']); @endphp
                    <a href="{{ $item['route'] }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition {{ $active ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            @if ($notificationsEnabled)
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button class="relative inline-flex items-center rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if ($bookingNotifications->count() > 0)
                                <span class="absolute -right-1 -top-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-rose-600 px-1 text-[10px] font-semibold text-white">
                                    {{ $bookingNotifications->count() }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Booking Notifications
                        </div>

                        @forelse ($bookingNotifications as $item)
                            <div class="border-t border-slate-100 px-4 py-3 text-sm">
                                <p class="font-semibold text-slate-800">
                                    Room {{ $item->booking?->room?->room_number ?? 'N/A' }} booking request
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    Customer: {{ $item->booking?->customer?->name ?? 'N/A' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $item->created_at?->diffForHumans() }}
                                </p>
                                <form method="POST" action="{{ route('notifications.accept', $item) }}" class="mt-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
                                        Accept Booking
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="border-t border-slate-100 px-4 py-3 text-sm text-slate-500">
                                No pending notifications.
                            </div>
                        @endforelse
                    </x-slot>
                </x-dropdown>
            @endif

            <a href="{{ route('profile.edit') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Profile
            </a>

            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <span>{{ $user->name }}</span>
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Profile Settings
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <button @click="open = ! open" class="inline-flex items-center rounded-lg p-2 text-slate-600 hover:bg-slate-100 sm:hidden">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-slate-200 bg-white sm:hidden">
        <div class="space-y-1 px-4 py-3">
            @foreach ($navItems as $item)
                @php $active = request()->routeIs($item['active']); @endphp
                <a href="{{ $item['route'] }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium {{ $active ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="border-t border-slate-200 px-4 py-3">
            <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
            <p class="text-xs text-slate-500">{{ $user->email }}</p>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">
                    Profile Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
