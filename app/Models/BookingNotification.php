<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingNotification extends Model
{
    protected $fillable = [
        'booking_id',
        'hotel_id',
        'recipient_user_id',
        'recipient_role',
        'priority',
        'status',
        'seen_at',
        'accepted_at',
        'accepted_by_user_id',
    ];

    protected $casts = [
        'seen_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by_user_id');
    }

    public function isActionableFor(User $user): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        if ((int) $this->recipient_user_id !== (int) $user->id) {
            return false;
        }

        $rolePriority = [
            'staff' => 1,
            'admin' => 2,
            'super_admin' => 3,
        ];

        if (($rolePriority[$user->role] ?? null) !== (int) $this->priority) {
            return false;
        }

        return !self::query()
            ->where('booking_id', $this->booking_id)
            ->where('status', 'pending')
            ->where('priority', '<', $this->priority)
            ->exists();
    }
}
