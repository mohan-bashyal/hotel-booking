<?php

namespace App\Services\Admin;

use App\Models\Room;

class RoomService
{
    public function list(int $hotelId)
    {
        return Room::with('roomType')
            ->where('hotel_id', $hotelId)
            ->latest()
            ->get();
    }

    public function store(array $data, int $hotelId)
    {
        return Room::create([
            'room_number' => $data['room_number'],
            'room_type_id' => $data['room_type_id'],
            'hotel_id' => $hotelId,
        ]);
    }

    public function update(Room $room, array $data)
    {
        $room->update($data);
    }

    public function toggle(Room $room)
    {
        $room->update([
            'is_active' => !$room->is_active,
        ]);
    }

    public function delete(Room $room)
    {
        $room->delete();
    }
}
