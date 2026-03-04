<?php

namespace App\Services\Admin;

use App\Models\User;

class StaffService
{
    public function list(int $hotelId)
    {
        return User::where('role', 'staff')
            ->where('hotel_id', $hotelId)
            ->latest()
            ->get();
    }

    public function store(array $data, int $hotelId): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'staff',
            'hotel_id' => $hotelId,
            'is_active' => true,
        ]);
    }

    public function update(User $staff, array $data): void
    {
        $staff->update($data);
    }

    public function toggle(User $staff): void
    {
        $staff->update([
            'is_active' => !$staff->is_active,
        ]);
    }

    public function delete(User $staff): void
    {
        $staff->delete();
    }
}
