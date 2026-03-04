<?php

namespace App\Services;

use App\Models\Hotel;

class HotelService
{
    public function getAll()
    {
        return Hotel::latest()->get();
    }

    public function create(array $data): Hotel
    {
        return Hotel::create($data);
    }

    public function update(Hotel $hotel, array $data): Hotel
    {
        $hotel->update($data);
        return $hotel;
    }

    public function delete(Hotel $hotel): void
    {
        $hotel->delete();
    }
}
