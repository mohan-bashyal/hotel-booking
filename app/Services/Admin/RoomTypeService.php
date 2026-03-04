<?php

namespace App\Services\Admin;

use App\Models\RoomType;

class RoomTypeService
{
    public function list(int $hotelId)
    {
        return RoomType::where('hotel_id', $hotelId)->latest()->get();
    }

    public function store(array $data, int $hotelId)
    {
        return RoomType::create([
            ...$data,
            'hotel_id' => $hotelId,
        ]);
    }

    public function update(RoomType $roomType, array $data)
    {
        $roomType->update($data);
    }

    public function toggle(RoomType $roomType)
    {
        $roomType->update([
            'is_active' => !$roomType->is_active,
        ]);
    }

    public function delete(RoomType $roomType)
    {
        $roomType->delete();
    }
}
