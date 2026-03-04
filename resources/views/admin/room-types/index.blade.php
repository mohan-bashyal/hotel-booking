<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-bold">Room Types</h2>
            <a href="{{ route('admin.room-types.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add
            </a>
        </div>
    </x-slot>

    <div class="p-6">
        <table class="w-full border">
            <tr class="bg-gray-100">
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            @foreach($roomTypes as $type)
            <tr>
                <td>{{ $type->name }}</td>
                <td>{{ $type->price }}</td>
                <td>{{ $type->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.room-types.edit',$type) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
