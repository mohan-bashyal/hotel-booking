<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\StaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct(private StaffService $service) {}

    private function hotelId(): int
    {
        $hotelId = auth()->user()?->hotel_id;

        abort_if(is_null($hotelId), 403, 'Admin is not assigned to any hotel.');

        return (int) $hotelId;
    }

    public function index()
    {
        $staffs = $this->service->list($this->hotelId());

        return view('admin.staffs.index', compact('staffs'));
    }

    public function create()
    {
        return view('admin.staffs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $this->service->store($data, $this->hotelId());

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Staff created successfully');
    }

    public function edit(User $staff)
    {
        abort_if($staff->role !== 'staff' || $staff->hotel_id !== $this->hotelId(), 403);

        return view('admin.staffs.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        abort_if($staff->role !== 'staff' || $staff->hotel_id !== $this->hotelId(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
        ]);

        $this->service->update($staff, $data);

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Staff updated successfully');
    }

    public function toggle(User $staff)
    {
        abort_if($staff->role !== 'staff' || $staff->hotel_id !== $this->hotelId(), 403);

        $this->service->toggle($staff);

        return back()->with('success', 'Staff status updated');
    }

    public function destroy(User $staff)
    {
        abort_if($staff->role !== 'staff' || $staff->hotel_id !== $this->hotelId(), 403);

        $this->service->delete($staff);

        return back()->with('success', 'Staff deleted');
    }
}
