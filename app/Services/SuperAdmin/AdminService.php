<?php

namespace App\Services\SuperAdmin;

use App\Models\User;

class AdminService
{
    public function getAdmins()
    {
        return User::with('hotel')
            ->where('role', 'admin')
            ->latest()
            ->get();
    }

    public function toggleStatus(User $admin): void
    {
        $admin->update([
            'is_active' => !$admin->is_active,
        ]);
    }

    public function updateAdmin(User $admin, array $data): void
    {
        $admin->update($data);
    }

    public function deleteAdmin(User $admin): void
    {
        $admin->delete();
    }
}
