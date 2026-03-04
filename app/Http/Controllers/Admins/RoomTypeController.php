<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Services\Admin\RoomTypeService;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function __construct(
        private RoomTypeService $service
    ) {}

    private function hotelId(): int
    {
        return auth()->user()->hotel_id;
    }

    public function index()
    {
        $roomTypes = $this->service->list($this->hotelId());

        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.room-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $this->service->store($data, $this->hotelId());

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type created');
    }

    public function edit(RoomType $roomType)
    {
        abort_if($roomType->hotel_id !== $this->hotelId(), 403);

        return view('admin.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        abort_if($roomType->hotel_id !== $this->hotelId(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $this->service->update($roomType, $data);

        return back()->with('success', 'Updated');
    }

    public function destroy(RoomType $roomType)
    {
        abort_if($roomType->hotel_id !== $this->hotelId(), 403);

        $this->service->delete($roomType);

        return back()->with('success', 'Deleted');
    }
}
