<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold">Hotel Admins</h2>

            <a href="{{ route('superadmin.admins.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Create Admin
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Hotel</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td class="p-2 border">{{ $admin->name }}</td>
                    <td class="p-2 border">{{ $admin->email }}</td>
                    <td class="p-2 border">{{ $admin->hotel?->name }}</td>

                    <td class="p-2 border">
                        <span class="px-2 py-1 rounded text-white
                            {{ $admin->is_active ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $admin->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="p-2 border flex gap-3">
                        {{-- Toggle --}}
                        <form method="POST"
                              action="{{ route('superadmin.admins.toggle', $admin) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-yellow-600">
                                {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        {{-- Edit --}}
                        <a href="{{ route('superadmin.admins.edit', $admin) }}"
                           class="text-blue-600">
                            Edit
                        </a>

                        {{-- Delete --}}
                        <form method="POST"
                              action="{{ route('superadmin.admins.destroy', $admin) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-600"
                                    onclick="return confirm('Delete admin?')">
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
