<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl">Hotels</h2>

            <a href="{{ route('superadmin.hotels.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add Hotel
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-6 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">City</th>
                    <th class="p-2 border">Country</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hotels as $hotel)
                    <tr>
                        <td class="p-2 border">{{ $hotel->name }}</td>
                        <td class="p-2 border">{{ $hotel->city }}</td>
                        <td class="p-2 border">{{ $hotel->country }}</td>
                        <td class="p-2 border flex gap-3">
                            <a href="{{ route('superadmin.hotels.edit', $hotel) }}"
                               class="text-blue-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('superadmin.hotels.destroy', $hotel) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600"
                                        onclick="return confirm('Delete this hotel?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">
                            No hotels found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
