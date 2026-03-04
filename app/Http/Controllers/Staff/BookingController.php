<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    private function hotelId(): int
    {
        $hotelId = auth()->user()?->hotel_id;

        abort_if(is_null($hotelId), 403, 'Staff is not assigned to any hotel.');

        return (int) $hotelId;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $validStatuses = ['pending', 'confirmed', 'cancelled'];

        $bookings = Booking::query()
            ->with(['room:id,room_number', 'customer:id,name,email', 'staff:id,name'])
            ->where('hotel_id', $this->hotelId())
            ->when(in_array($status, $validStatuses, true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staff.bookings.index', compact('bookings', 'status'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        abort_if($booking->hotel_id !== $this->hotelId(), 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ]);

        $booking->update([
            'status' => $data['status'],
            'staff_id' => auth()->id(),
        ]);

        if (in_array($data['status'], ['confirmed', 'cancelled'], true)) {
            BookingNotification::query()
                ->where('booking_id', $booking->id)
                ->where('status', 'pending')
                ->update([
                    'status' => $data['status'] === 'confirmed' ? 'accepted' : 'expired',
                    'accepted_at' => $data['status'] === 'confirmed' ? now() : null,
                    'accepted_by_user_id' => $data['status'] === 'confirmed' ? auth()->id() : null,
                    'updated_at' => now(),
                ]);
        }

        return back()->with('success', 'Booking status updated successfully.');
    }
}
