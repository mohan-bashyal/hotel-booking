<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl">Staff Management</h2>
            <a href="{{ route('admin.staffs.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add Staff
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
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffs as $staff)
                <tr>
                    <td class="p-2 border">{{ $staff->name }}</td>
                    <td class="p-2 border">{{ $staff->email }}</td>
                    <td class="p-2 border">
                        <span class="px-2 py-1 rounded text-white {{ $staff->is_active ? 'bg-green-600':'bg-red-600' }}">
                            {{ $staff->is_active ? 'Active':'Inactive' }}
                        </span>
                    </td>
                    <td class="p-2 border flex gap-3">
                        <form method="POST" action="{{ route('admin.staffs.toggle', $staff) }}">
                            @csrf @method('PATCH')
                            <button class="text-yellow-600">
                                {{ $staff->is_active ? 'Deactivate':'Activate' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.staffs.edit', $staff) }}" class="text-blue-600">Edit</a>

                        <form method="POST" action="{{ route('admin.staffs.destroy', $staff) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('Delete staff?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-3 text-center text-gray-500">No staff found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
