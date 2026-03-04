<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'description',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Hotel → Users (admins & staff)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Later: Hotel → Rooms
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function admins()
{
    return $this->hasMany(User::class);
}

}
