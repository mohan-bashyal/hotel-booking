<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\Admin\RoomService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function __construct(private RoomService $service) {}

    private function hotelId(): int
    {
        return auth()->user()->hotel_id;
    }

    public function index()
    {
        $rooms = $this->service->list($this->hotelId());

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('hotel_id', $this->hotelId())
            ->where('is_active', true)
            ->get();

        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type_id' => [
                'required',
                Rule::exists('room_types', 'id')->where(fn ($q) => $q->where('hotel_id', $this->hotelId())),
            ],
        ]);

        $this->service->store($data, $this->hotelId());

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created');
    }

    public function edit(Room $room)
    {
        abort_if($room->hotel_id !== $this->hotelId(), 403);

        $roomTypes = RoomType::where('hotel_id', $this->hotelId())->get();

        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        abort_if($room->hotel_id !== $this->hotelId(), 403);

        $data = $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type_id' => [
                'required',
                Rule::exists('room_types', 'id')->where(fn ($q) => $q->where('hotel_id', $this->hotelId())),
            ],
            'is_active' => 'required|boolean',
        ]);

        $this->service->update($room, $data);

        return back()->with('success', 'Room updated');
    }

    public function toggle(Room $room)
    {
        abort_if($room->hotel_id !== $this->hotelId(), 403);

        $this->service->toggle($room);

        return back()->with('success', 'Room status updated');
    }

    public function destroy(Room $room)
    {
        abort_if($room->hotel_id !== $this->hotelId(), 403);

        $this->service->delete($room);

        return back()->with('success', 'Room deleted');
    }
}
