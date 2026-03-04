<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Create Staff</h2>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">
        <form method="POST" action="{{ route('admin.staffs.store') }}" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf

            <div>
                <label class="block mb-1">Name</label>
                <input name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
                @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2">
                @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <div class="flex gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
                <a href="{{ route('admin.staffs.index') }}" class="px-4 py-2 border rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
