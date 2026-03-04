<?php

namespace App\Http\Controllers;

use App\Models\BookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingNotificationController extends Controller
{
    public function accept(Request $request, BookingNotification $notification)
    {
        $user = $request->user();

        abort_unless(
            in_array($user?->role, ['staff', 'admin', 'super_admin'], true),
            403
        );

        abort_unless($notification->isActionableFor($user), 403, 'This notification is not ready for your role yet.');

        DB::transaction(function () use ($notification, $user) {
            $notification->booking->update([
                'status' => 'confirmed',
                'staff_id' => $user->role === 'staff' ? $user->id : $notification->booking->staff_id,
            ]);

            BookingNotification::query()
                ->where('booking_id', $notification->booking_id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'accepted',
                    'accepted_at' => now(),
                    'accepted_by_user_id' => $user->id,
                    'seen_at' => now(),
                    'updated_at' => now(),
                ]);
        });

        return back()->with('success', 'Booking accepted successfully.');
    }
}
