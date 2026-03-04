<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;

class AdDashboardController extends Controller
{
    public function index()
    {
        $hotelId = auth()->user()->hotel_id;

        return view('admin.dashboard', [
            'roomTypes' => RoomType::where('hotel_id',$hotelId)->count(),
            'rooms'     => Room::where('hotel_id',$hotelId)->count(),
            'staffs'    => User::where('role', 'staff')->where('hotel_id', $hotelId)->count(),
        ]);
    }
}
