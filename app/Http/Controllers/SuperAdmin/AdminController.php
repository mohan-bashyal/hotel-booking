<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Hotel;
use App\Services\SuperAdmin\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function index()
    {
        $admins = $this->adminService->getAdmins();
        return view('superadmin.admins.index', compact('admins'));
    }

    public function create()
    {
        $hotels = Hotel::where('is_active', true)->get();
        return view('superadmin.admins.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'hotel_id'  => 'required|exists:hotels,id',
        ]);

        app(AdminService::class)->createAdmin($validated);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin created successfully');
    }

    public function edit(User $admin)
    {
        abort_if($admin->role !== 'admin', 403);

        $hotels = Hotel::where('is_active', true)->get();
        return view('superadmin.admins.edit', compact('admin','hotels'));
    }

    public function update(Request $request, User $admin)
    {
        abort_if($admin->role !== 'admin', 403);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $this->adminService->updateAdmin($admin, $validated);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin updated successfully');
    }

    public function toggle(User $admin)
    {
        abort_if($admin->role !== 'admin', 403);

        $this->adminService->toggleStatus($admin);

        return back()->with('success', 'Admin status updated');
    }

    public function destroy(User $admin)
    {
        abort_if($admin->role !== 'admin', 403);

        $this->adminService->deleteAdmin($admin);

        return back()->with('success', 'Admin deleted');
    }
}
