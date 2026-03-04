<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold">Edit Room Type</h2>

            <a href="{{ route('admin.room-types.index') }}"
               class="text-blue-600 hover:underline">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.room-types.update', $roomType) }}"
              class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            {{-- Room Type Name --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Room Type Name
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $roomType->name) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            {{-- Price --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Price (per night)
                </label>
                <input type="number"
                       name="price"
                       step="0.01"
                       value="{{ old('price', $roomType->price) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label class="block font-semibold mb-1">
                    Status
                </label>
                <select name="is_active"
                        class="w-full border p-2 rounded">
                    <option value="1" @selected($roomType->is_active)>
                        Active
                    </option>
                    <option value="0" @selected(!$roomType->is_active)>
                        Inactive
                    </option>
                </select>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.room-types.index') }}"
                   class="px-4 py-2 border rounded">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
