<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl">Rooms</h2>
            <a href="{{ route('admin.rooms.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add Room
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Room #</th>
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr>
                    <td class="p-2 border">{{ $room->room_number }}</td>
                    <td class="p-2 border">{{ $room->roomType?->name }}</td>
                    <td class="p-2 border">
                        <span class="px-2 py-1 rounded text-white {{ $room->is_active ? 'bg-green-600':'bg-red-600' }}">
                            {{ $room->is_active ? 'Active':'Inactive' }}
                        </span>
                    </td>
                    <td class="p-2 border flex gap-3">
                        <form method="POST" action="{{ route('admin.rooms.toggle',$room) }}">
                            @csrf @method('PATCH')
                            <button class="text-yellow-600">
                                {{ $room->is_active ? 'Deactivate':'Activate' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.rooms.edit',$room) }}" class="text-blue-600">Edit</a>

                        <form method="POST" action="{{ route('admin.rooms.destroy',$room) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-600"
                                    onclick="return confirm('Delete room?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
