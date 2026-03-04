<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'hotel_id',
        'room_id',
        'customer_id',
        'staff_id',
        'check_in',
        'check_out',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function notifications()
    {
        return $this->hasMany(BookingNotification::class);
    }
}
