<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $primaryKey = 'ID';

    function booking_details()
    {
        return $this->hasMany(BookingDetail::class, 'BookingID');
    }

    function coupon()
    {
        return $this->belongsTo(Coupon::class, 'CouponID');
    }
}
