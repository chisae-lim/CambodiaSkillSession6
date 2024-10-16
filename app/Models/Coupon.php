<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $primaryKey = 'ID';

    function bookings()
    {
        return $this->hasMany(Booking::class, 'CouponID');
    }

}
