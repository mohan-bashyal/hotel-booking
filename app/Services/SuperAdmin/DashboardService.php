<?php

namespace App\Services\SuperAdmin;

use App\Models\User;
use App\Models\Hotel;

class DashboardService
{
    public function stats(): array
    {
        return [
            'hotels'    => Hotel::count(),
            'admins'    => User::where('role','admin')->count(),
            'staff'     => User::where('role','staff')->count(),
            'customers' => User::where('role','customer')->count(),
        ];
    }
}
