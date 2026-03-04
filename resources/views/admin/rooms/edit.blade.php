<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-bold text-xl">Edit Room</h2>
            <a href="{{ route('admin.rooms.index') }}" class="text-blue-600">← Back</a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form method="POST"
              action="{{ route('admin.rooms.update',$room) }}"
              class="bg-white p-6 rounded shadow">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="font-semibold">Room Number</label>
                <input name="room_number"
                       value="{{ old('room_number',$room->room_number) }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Room Type</label>
                <select name="room_type_id" class="w-full border p-2 rounded">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}"
                            @selected($room->room_type_id === $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="font-semibold">Status</label>
                <select name="is_active" class="w-full border p-2 rounded">
                    <option value="1" @selected($room->is_active)>Active</option>
                    <option value="0" @selected(!$room->is_active)>Inactive</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                <button class="px-6 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
