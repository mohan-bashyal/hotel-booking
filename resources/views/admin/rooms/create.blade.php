<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-bold text-xl">Create Room</h2>
            <a href="{{ route('admin.rooms.index') }}" class="text-blue-600">← Back</a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.rooms.store') }}"
              class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">Room Number</label>
                <input name="room_number" value="{{ old('room_number') }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Room Type</label>
                <select name="room_type_id" class="w-full border p-2 rounded" required>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                <button class="px-6 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
