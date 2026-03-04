<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'check_in' => ['nullable', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date', 'after:check_in'],
        ]);

        $checkIn = $validated['check_in'] ?? null;
        $checkOut = $validated['check_out'] ?? null;
        $hasDates = $checkIn && $checkOut;

        $rooms = Room::query()
            ->with(['hotel:id,name', 'roomType:id,name,price'])
            ->where('is_active', true)
            ->whereHas('roomType', fn ($q) => $q->where('is_active', true))
            ->when($hasDates, function ($query) use ($checkIn, $checkOut) {
                $query->whereDoesntHave('bookings', function ($bookingQuery) use ($checkIn, $checkOut) {
                    $bookingQuery->whereIn('status', ['pending', 'confirmed'])
                        ->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            })
            ->latest()
            ->get();

        $myBookings = Booking::query()
            ->with(['room:id,room_number,room_type_id,hotel_id', 'room.hotel:id,name', 'room.roomType:id,name,price'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customer.rooms', [
            'rooms' => $rooms,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'hasDates' => $hasDates,
            'myBookings' => $myBookings,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => [
                'required',
                Rule::exists('rooms', 'id')->where(fn ($q) => $q->where('is_active', true)),
            ],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $room = Room::with('roomType')->findOrFail($data['room_id']);

        if (!$room->roomType || !$room->roomType->is_active) {
            return back()->withErrors([
                'room_id' => 'Selected room is not available for booking.',
            ])->withInput();
        }

        $isBooked = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $data['check_out'])
            ->where('check_out', '>', $data['check_in'])
            ->exists();

        if ($isBooked) {
            return back()->withErrors([
                'room_id' => 'Room is no longer available in this date range.',
            ])->withInput();
        }

        $booking = Booking::create([
            'hotel_id' => $room->hotel_id,
            'room_id' => $room->id,
            'customer_id' => auth()->id(),
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'status' => 'pending',
        ]);

        $this->createBookingNotifications($booking);

        return redirect()->route('customer.rooms.index', [
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
        ])->with('success', 'Booking submitted. Current status: pending.');
    }

    private function createBookingNotifications(Booking $booking): void
    {
        $now = now();
        $rows = [];

        $staffIds = User::query()
            ->where('role', 'staff')
            ->where('hotel_id', $booking->hotel_id)
            ->where('is_active', true)
            ->pluck('id');

        foreach ($staffIds as $id) {
            $rows[] = [
                'booking_id' => $booking->id,
                'hotel_id' => $booking->hotel_id,
                'recipient_user_id' => $id,
                'recipient_role' => 'staff',
                'priority' => 1,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $adminIds = User::query()
            ->where('role', 'admin')
            ->where('hotel_id', $booking->hotel_id)
            ->where('is_active', true)
            ->pluck('id');

        foreach ($adminIds as $id) {
            $rows[] = [
                'booking_id' => $booking->id,
                'hotel_id' => $booking->hotel_id,
                'recipient_user_id' => $id,
                'recipient_role' => 'admin',
                'priority' => 2,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $superAdminIds = User::query()
            ->where('role', 'super_admin')
            ->where('is_active', true)
            ->pluck('id');

        foreach ($superAdminIds as $id) {
            $rows[] = [
                'booking_id' => $booking->id,
                'hotel_id' => $booking->hotel_id,
                'recipient_user_id' => $id,
                'recipient_role' => 'super_admin',
                'priority' => 3,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('booking_notifications')->insert($rows);
        }
    }
}
