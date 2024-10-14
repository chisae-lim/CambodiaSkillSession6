<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'ID';

    function items()
    {
        return $this->hasMany(Item::class, 'UserID');
    }

    function bookings()
    {
        return $this->hasMany(Booking::class, 'UserID');
    }
}
