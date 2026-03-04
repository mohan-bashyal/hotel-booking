<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Create Hotel Admin</h2>
    </x-slot>

    <div class="py-6 px-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('superadmin.admins.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Assign Hotel</label>
                <select name="hotel_id"
                        class="w-full border p-2 rounded"
                        required>
                    <option value="">-- Select Hotel --</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}">
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Create Admin
            </button>

            <a href="{{ route('superadmin.admins.index') }}"
               class="ml-3 text-gray-600">
                Cancel
            </a>
        </form>

    </div>
</x-app-layout>
