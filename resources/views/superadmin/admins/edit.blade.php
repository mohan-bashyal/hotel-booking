<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Edit Admin</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">

        <form method="POST"
              action="{{ route('superadmin.admins.update', $admin) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name"
                       value="{{ $admin->name }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ $admin->email }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label>Hotel</label>
                <select name="hotel_id"
                        class="w-full border p-2 rounded">
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}"
                            @selected($admin->hotel_id === $hotel->id)>
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update Admin
            </button>
        </form>

    </div>
</x-app-layout>
