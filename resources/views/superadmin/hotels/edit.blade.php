<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">Edit Hotel</h2>
    </x-slot>

    <div class="py-6 px-6 max-w-xl mx-auto">

        <form method="POST"
              action="{{ route('superadmin.hotels.update', $hotel) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Hotel Name</label>
                <input type="text" name="name"
                       value="{{ $hotel->name }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">City</label>
                <input type="text" name="city"
                       value="{{ $hotel->city }}"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Country</label>
                <input type="text" name="country"
                       value="{{ $hotel->country }}"
                       class="w-full border p-2 rounded">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update Hotel
            </button>

            <a href="{{ route('superadmin.hotels.index') }}"
               class="ml-3 text-gray-600">
                Cancel
            </a>
        </form>

    </div>
</x-app-layout>
